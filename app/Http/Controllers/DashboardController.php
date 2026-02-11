<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() 
    {
        $user = Auth::user();
        $sellerPendingOrdersCount = 0;
        $sellerActiveProductsCount = 0;

        if ($user && $user->isSeller()) {
            $sellerPendingOrdersCount = Order::where('status', 'pending')
                ->whereHas('items.product', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->count();

            $sellerActiveProductsCount = Product::where('user_id', $user->id)
                ->where('is_active', true)
                ->count();
        }

        $buyerRecentOrders = [];
        $buyerWishlist = [];
        $buyerOrdersCount = 0;
        $buyerWishlistCount = 0;

        if ($user && $user->isBuyer()) {
             $buyerRecentOrders = Order::where('user_id', $user->id)
                ->with(['items.product'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            
            $buyerOrdersCount = Order::where('user_id', $user->id)->count();

            $buyerWishlist = $user->likes()
                ->with('product')
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->get();
                
            $buyerWishlistCount = $user->likes()->count();
        }

        return view('dashboard', compact(
            'sellerPendingOrdersCount', 
            'sellerActiveProductsCount',
            'buyerRecentOrders',
            'buyerWishlist',
            'buyerOrdersCount',
            'buyerWishlistCount'
        ));
    }
}
