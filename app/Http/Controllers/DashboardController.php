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

        return view('dashboard', compact('sellerPendingOrdersCount', 'sellerActiveProductsCount'));
    }
}
