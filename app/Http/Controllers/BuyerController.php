<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Review;
use App\Models\ProductLike;
use App\Models\User;
use App\Models\StockMovement;
use App\Models\OrderStatusHistory;
use App\Notifications\AdminAlertNotification;
use App\Notifications\NewOrderNotification;
use App\Notifications\NewReviewNotification;
use App\Notifications\OrderConfirmationNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class BuyerController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)
            ->with(['category', 'reviews']);

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->get();
        $categories = Category::all();

        return view('marketplace', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::where('is_active', true)
            ->with(['category', 'reviews.user'])
            ->findOrFail($id);
        $userReview = $product->reviews()->where('user_id', Auth::id())->first();

        return view('buyer.show', compact('product', 'userReview'));
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::where('is_active', true)->findOrFail($id);
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $requestedQty = (int) ($request->quantity ?? 1);
        if ($requestedQty <= 0) {
            $requestedQty = 1;
        }

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $newQty = $cartItem->quantity + $requestedQty;
            if ($newQty > $product->stock_quantity) {
                return redirect()->back()->with('error', 'Quantité demandée supérieure au stock disponible.');
            }
            $cartItem->update(['quantity' => $newQty]);
        } else {
            if ($requestedQty > $product->stock_quantity) {
                return redirect()->back()->with('error', 'Quantité demandée supérieure au stock disponible.');
            }
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $requestedQty,
                'price' => $product->price
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart.');
    }

    public function cart()
    {
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();
        return view('buyer.cart', compact('cart'));
    }

    public function removeFromCart($itemId)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if (!$cart) {
            return redirect()->route('buyer.cart')->with('error', 'Your cart is empty.');
        }

        $item = CartItem::where('id', $itemId)
            ->where('cart_id', $cart->id)
            ->first();

        if (!$item) {
            return redirect()->route('buyer.cart')->with('error', 'Item not found in your cart.');
        }

        $item->delete();

        if ($cart->items()->count() === 0) {
            $cart->delete();
        }

        return redirect()->route('buyer.cart')->with('success', 'Item removed from cart.');
    }

    public function checkout()
    {
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('marketplace')->with('error', 'Your cart is empty.');
        }

        $stripeConfigured = filled(config('services.stripe.key')) && filled(config('services.stripe.secret'));

        return view('buyer.checkout', compact('cart', 'stripeConfigured'));
    }

    public function placeOrder(Request $request)
    {
        \Log::info('Place order called', ['user_id' => Auth::id(), 'has_buyer_role' => Auth::user()->hasRole('buyer')]);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'payment_method' => 'required|in:cod,bank_transfer,card',
        ]);

        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('marketplace')->with('error', 'Your cart is empty.');
        }

        $shippingAddress = [
            'name' => $request->full_name,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'phone' => $request->phone
        ];

        $order = null;
        $paymentMethod = $request->payment_method;

        if ($paymentMethod === 'card') {
            if (!$this->isStripeConfigured()) {
                return redirect()
                    ->route('buyer.checkout')
                    ->with('error', 'Card payments are currently unavailable. Please use another payment method.');
            }

            return $this->redirectToStripeCheckout($cart, $shippingAddress);
        }

        try {
            DB::transaction(function () use ($cart, $shippingAddress, $paymentMethod, &$order) {
                $order = $this->createOrderFromCart(
                    $cart,
                    $shippingAddress,
                    $paymentMethod
                );
            });
        } catch (\Exception $e) {
            return redirect()->route('buyer.cart')->with('error', 'Order failed: ' . $e->getMessage());
        }

        $this->sendOrderNotifications($order, $shippingAddress);

        return redirect()->route('buyer.orders')->with([
            'success' => 'Order placed successfully! Check your email for confirmation.',
            'payment_method' => $paymentMethod,
            'payment_status' => $paymentMethod === 'cod' ? 'completed' : 'pending'
        ]);
    }

    public function stripeSuccess(Request $request): RedirectResponse
    {
        if (!$this->isStripeConfigured()) {
            return redirect()->route('buyer.checkout')->with('error', 'Stripe configuration is missing.');
        }

        $sessionId = (string) $request->query('session_id', '');
        if ($sessionId === '') {
            return redirect()->route('buyer.checkout')->with('error', 'Missing Stripe session.');
        }

        $stripe = new StripeClient(config('services.stripe.secret'));

        try {
            $stripeSession = $stripe->checkout->sessions->retrieve($sessionId, [
                'expand' => ['payment_intent'],
            ]);
        } catch (ApiErrorException $e) {
            return redirect()->route('buyer.checkout')->with('error', 'Unable to verify Stripe payment: ' . $e->getMessage());
        }

        $paymentIntentId = is_string($stripeSession->payment_intent)
            ? $stripeSession->payment_intent
            : ($stripeSession->payment_intent->id ?? null);

        if ($paymentIntentId) {
            $existingPayment = Payment::where('payment_method', 'card')
                ->where('transaction_id', $paymentIntentId)
                ->first();

            if ($existingPayment) {
                session()->forget("stripe_checkout.$sessionId");

                return redirect()->route('buyer.orders')->with([
                    'success' => 'Payment already confirmed.',
                    'payment_method' => 'card',
                    'payment_status' => 'completed',
                ]);
            }
        }

        if (($stripeSession->metadata->user_id ?? null) !== (string) Auth::id()) {
            return redirect()->route('buyer.checkout')->with('error', 'Invalid Stripe session for this account.');
        }

        if ($stripeSession->payment_status !== 'paid') {
            return redirect()->route('buyer.checkout')->with('error', 'Payment was not completed.');
        }

        $checkoutContext = session()->get("stripe_checkout.$sessionId");
        $shippingAddress = $checkoutContext['shipping_address'] ?? null;
        $cartSnapshot = $checkoutContext['cart_snapshot'] ?? [];
        $snapshotTotal = (float) ($checkoutContext['total_amount'] ?? 0);

        if (!is_array($shippingAddress)) {
            return redirect()->route('buyer.checkout')->with('error', 'Checkout session expired. Please try again.');
        }

        if (!$this->isValidCartSnapshot($cartSnapshot) || $snapshotTotal <= 0) {
            return redirect()->route('buyer.checkout')->with('error', 'Checkout data is invalid. Please contact support.');
        }

        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();

        try {
            $order = DB::transaction(function () use (
                $cart,
                $shippingAddress,
                $stripeSession,
                $paymentIntentId,
                $cartSnapshot,
                $snapshotTotal
            ) {
                return $this->createOrderFromSnapshot(
                    $cartSnapshot,
                    $snapshotTotal,
                    $shippingAddress,
                    'card',
                    [
                        'status' => 'completed',
                        'transaction_id' => $paymentIntentId ?? $stripeSession->id,
                        'processed_at' => now(),
                        'payment_details' => [
                            'stripe_checkout_session_id' => $stripeSession->id,
                            'stripe_payment_intent_id' => $paymentIntentId,
                        ],
                    ],
                    $cart
                );
            });
        } catch (\Exception $e) {
            return redirect()->route('buyer.checkout')->with('error', 'Order creation failed after payment: ' . $e->getMessage());
        }

        session()->forget("stripe_checkout.$sessionId");
        $this->sendOrderNotifications($order, $shippingAddress);

        return redirect()->route('buyer.orders')->with([
            'success' => 'Payment successful. Your order has been placed.',
            'payment_method' => 'card',
            'payment_status' => 'completed',
        ]);
    }

    public function stripeCancel(): RedirectResponse
    {
        return redirect()->route('buyer.checkout')->with('error', 'Stripe payment was canceled.');
    }

    private function redirectToStripeCheckout(Cart $cart, array $shippingAddress): RedirectResponse
    {
        $stripe = new StripeClient(config('services.stripe.secret'));

        $cartSnapshot = $cart->items->map(function ($item) {
            return [
                'product_id' => (int) $item->product_id,
                'quantity' => (int) $item->quantity,
                'unit_price' => (float) $item->price,
            ];
        })->values()->all();

        $lineItems = $cart->items->map(function ($item) {
            return [
                'price_data' => [
                    'currency' => 'mad',
                    'unit_amount' => $this->toStripeAmount((float) $item->price),
                    'product_data' => [
                        'name' => $item->product->name,
                    ],
                ],
                'quantity' => (int) $item->quantity,
            ];
        })->values()->all();

        try {
            $stripeSession = $stripe->checkout->sessions->create([
                'mode' => 'payment',
                'line_items' => $lineItems,
                'success_url' => route('buyer.stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('buyer.stripe.cancel'),
                'customer_email' => $shippingAddress['email'] ?? null,
                'metadata' => [
                    'user_id' => (string) Auth::id(),
                ],
            ]);
        } catch (ApiErrorException $e) {
            return redirect()->route('buyer.checkout')->with('error', 'Unable to start Stripe checkout: ' . $e->getMessage());
        }

        session()->put("stripe_checkout.{$stripeSession->id}", [
            'shipping_address' => $shippingAddress,
            'cart_snapshot' => $cartSnapshot,
            'total_amount' => (float) $cart->total_amount,
            'created_at' => now()->toIso8601String(),
        ]);

        return redirect()->away($stripeSession->url);
    }

    private function createOrderFromCart(
        Cart $cart,
        array $shippingAddress,
        string $paymentMethod,
        array $paymentOverrides = []
    ): Order {
        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'user_id' => Auth::id(),
            'status' => 'pending',
            'total_amount' => $cart->total_amount,
            'shipping_address' => $shippingAddress,
            'billing_address' => $shippingAddress,
        ]);

        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->price,
                'total_price' => $item->price * $item->quantity,
            ]);

            $item->product->decrement('stock_quantity', $item->quantity);
        }

        $paymentData = array_merge([
            'order_id' => $order->id,
            'payment_method' => $paymentMethod,
            'amount' => $cart->total_amount,
            'status' => $paymentMethod === 'cod' ? 'completed' : 'pending',
            'transaction_id' => $paymentMethod === 'bank_transfer' ? 'TXN-' . strtoupper(uniqid()) : null,
            'processed_at' => $paymentMethod === 'cod' ? now() : null,
        ], $paymentOverrides);

        Payment::create($paymentData);

        $cart->items()->delete();
        $cart->delete();

        return $order;
    }

    private function createOrderFromSnapshot(
        array $cartSnapshot,
        float $totalAmount,
        array $shippingAddress,
        string $paymentMethod,
        array $paymentOverrides = [],
        ?Cart $cart = null
    ): Order {
        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'user_id' => Auth::id(),
            'status' => 'pending',
            'total_amount' => $totalAmount,
            'shipping_address' => $shippingAddress,
            'billing_address' => $shippingAddress,
        ]);

        foreach ($cartSnapshot as $snapshotItem) {
            $product = Product::withTrashed()->find($snapshotItem['product_id']);
            if (!$product) {
                throw new \RuntimeException('Product not found while finalizing Stripe payment.');
            }

            $quantity = (int) $snapshotItem['quantity'];
            $unitPrice = (float) $snapshotItem['unit_price'];

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total_price' => $unitPrice * $quantity,
            ]);

            $product->decrement('stock_quantity', $quantity);
        }

        $paymentData = array_merge([
            'order_id' => $order->id,
            'payment_method' => $paymentMethod,
            'amount' => $totalAmount,
            'status' => $paymentMethod === 'cod' ? 'completed' : 'pending',
            'transaction_id' => $paymentMethod === 'bank_transfer' ? 'TXN-' . strtoupper(uniqid()) : null,
            'processed_at' => $paymentMethod === 'cod' ? now() : null,
        ], $paymentOverrides);

        Payment::create($paymentData);

        if ($cart) {
            $cart->items()->delete();
            $cart->delete();
        }

        return $order;
    }

    private function sendOrderNotifications(Order $order, array $shippingAddress): void
    {
        try {
            Notification::route('mail', $shippingAddress['email'])
                ->notify(new OrderConfirmationNotification($order, $shippingAddress['email']));
        } catch (\Exception $e) {
            \Log::error('Email failed: ' . $e->getMessage());
        }

        try {
            $order->loadMissing(['user', 'items.product.vendor']);

            $itemsBySeller = $order->items
                ->filter(function ($item) {
                    return $item->product && $item->product->vendor;
                })
                ->groupBy(function ($item) {
                    return $item->product->vendor->id;
                });

            foreach ($itemsBySeller as $sellerItems) {
                $seller = $sellerItems->first()->product->vendor;
                $sellerTotal = (float) $sellerItems->sum(function ($item) {
                    return (float) $item->total_price;
                });

                $seller->notify(new NewOrderNotification($order, $sellerTotal));
            }
        } catch (\Exception $e) {
            \Log::error('Seller notification failed: ' . $e->getMessage());
        }
    }

    private function isStripeConfigured(): bool
    {
        return filled(config('services.stripe.key')) && filled(config('services.stripe.secret'));
    }

    private function toStripeAmount(float $amount): int
    {
        return (int) round($amount * 100);
    }

    private function isValidCartSnapshot(mixed $cartSnapshot): bool
    {
        if (!is_array($cartSnapshot) || count($cartSnapshot) === 0) {
            return false;
        }

        foreach ($cartSnapshot as $item) {
            if (!is_array($item)) {
                return false;
            }

            if (!isset($item['product_id'], $item['quantity'], $item['unit_price'])) {
                return false;
            }

            if ((int) $item['product_id'] <= 0 || (int) $item['quantity'] <= 0 || (float) $item['unit_price'] <= 0) {
                return false;
            }
        }

        return true;
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.product', 'payments'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('buyer.orders', compact('orders'));
    }

    public function orderDetails($id)
    {
        $order = Order::with(['items.product', 'payments'])->where('user_id', Auth::id())->findOrFail($id);
        return view('buyer.order-details', compact('order'));
    }

    public function addReview(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        $product = Product::with('vendor')->findOrFail($productId);

        $review = Review::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $productId],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
                'moderation_status' => 'approved',
            ]
        );
        if ($product->vendor) {
            $review->load(['user', 'product']);
            $product->vendor->notify(new NewReviewNotification($review));
        }

        $admins = User::role('admin')->whereKeyNot(Auth::id())->get();
        if ($admins->isNotEmpty()) {
            Notification::send(
                $admins,
                new AdminAlertNotification(
                    'new_review',
                    'Nouvel avis sur ' . $product->name . ' (' . $review->rating . '★)',
                    route('admin.reviews')
                )
            );
        }

        return redirect()->back()->with('success', 'Review added successfully!');
    }

    public function toggleLike($productId)
    {
        $product = Product::findOrFail($productId);
        $userId = Auth::id();

        $like = ProductLike::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($like) {
            $like->delete();
            $message = 'Product unliked successfully!';
        } else {
            ProductLike::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
            $message = 'Product liked successfully!';
        }

        return redirect()->back()->with('success', $message);
    }
}
