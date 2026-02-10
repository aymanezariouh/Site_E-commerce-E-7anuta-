<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Review;
use App\Models\ProductLike;
use App\Models\User;
use App\Models\StockMovement;
use App\Models\OrderStatusHistory;
use App\Notifications\NewOrderNotification;
use App\Notifications\NewReviewNotification;
use App\Notifications\OrderConfirmationNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class BuyerController extends Controller
{
    public function index(Request $request)
    {
        // Show all active products - simplified query
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

    public function checkout()
    {
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('marketplace')->with('error', 'Your cart is empty.');
        }
        
        return view('buyer.checkout', compact('cart'));
    }

    public function placeOrder(Request $request)
    {
        \Log::info('Place order called', ['user_id' => Auth::id(), 'has_buyer_role' => Auth::user()->hasRole('buyer')]);
        
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|max:20'
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
        
        try {
            DB::transaction(function () use ($cart, $shippingAddress, &$order) {
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

                $cart->items()->delete();
                $cart->delete();
            });
        } catch (\Exception $e) {
            return redirect()->route('buyer.cart')->with('error', 'Order failed: ' . $e->getMessage());
        }

        // Send email outside transaction
        try {
            Notification::route('mail', $shippingAddress['email'])
                ->notify(new OrderConfirmationNotification($order, $shippingAddress['email']));
        } catch (\Exception $e) {
            \Log::error('Email failed: ' . $e->getMessage());
        }

        return redirect()->route('buyer.orders')->with([
            'success' => 'Order placed successfully! Check your email for confirmation.',
            'test_order_id' => $order->id
        ]);
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
        $order = Order::with('items.product')->where('user_id', Auth::id())->findOrFail($id);
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

        // Notify the seller about the new review
        if ($product->vendor) {
            $review->load(['user', 'product']);
            $product->vendor->notify(new NewReviewNotification($review));
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
