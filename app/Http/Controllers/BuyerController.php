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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BuyerController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()->inStock()->with(['category', 'reviews']);
        
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        
        $products = $query->get();
        $categories = Category::all();
        
        return view('buyer.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with(['category', 'reviews.user'])->findOrFail($id);
        $userReview = $product->reviews()->where('user_id', Auth::id())->first();
        
        return view('buyer.show', compact('product', 'userReview'));
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();
            
        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity ?? 1);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity ?? 1,
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
            return redirect()->route('buyer.produits')->with('error', 'Your cart is empty.');
        }
        
        return view('buyer.checkout', compact('cart'));
    }

    public function placeOrder(Request $request)
    {
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('buyer.produits')->with('error', 'Your cart is empty.');
        }

        DB::transaction(function () use ($cart, $request) {
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => Auth::id(),
                'status' => 'pending',
                'total_amount' => $cart->total_amount,
                'shipping_address' => $request->shipping_address,
                'billing_address' => $request->billing_address ?? $request->shipping_address,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
            }

            $cart->items()->delete();
            $cart->delete();
        });

        return redirect()->route('buyer.orders')->with('success', 'Order placed successfully!');
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())->with('items.product')->orderBy('created_at', 'desc')->get();
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

        Review::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $productId],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
                'status' => 'approved'
            ]
        );

        return redirect()->back()->with('success', 'Review added successfully!');
    }
}