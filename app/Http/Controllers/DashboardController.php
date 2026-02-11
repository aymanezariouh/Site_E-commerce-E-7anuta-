<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
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

        $moderatorPendingReviewsCount = 0;
        $moderatorSuspendedUsersCount = 0;
        $moderatorSuspendedProductsCount = 0;

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

        if ($user && $user->hasRole('moderator')) {
            $moderatorPendingReviewsCount = Review::where('is_approved', false)->count(); // Using is_approved=false as pending/hidden for now, or fetch all reviews requiring attention
            // Actually, looking at ModeratorController, 'hideReview' sets is_approved=false. 'showReview' sets is_approved=true.
            // But usually there's a 'pending' state.
            // AdminController uses 'moderation_status' = 'pending'.
            // ModeratorController just uses Review::all().
            // Let's use what AdminController uses for "pending" which seems more accurate for a dashboard: 'moderation_status' = 'pending'.
            // Wait, ModeratorController doesn't use moderation_status. It uses is_approved.
            // Let's check the Review model or database...
            // Actually AdminController uses 'moderation_status', 'pending'.
            // Let's assume 'moderation_status' exists.
            $moderatorPendingReviewsCount = Review::where('moderation_status', 'pending')->count();
             
             // If moderation_status column doesn't exist (I can't check schema easily right now without running a command), I might be safe using what AdminController uses.
             // Accessing AdminController.php... 
             // Line 207: where('moderation_status', 'pending')
             // So I will use that.

            $moderatorSuspendedUsersCount = User::onlyTrashed()->count();
            $moderatorSuspendedProductsCount = Product::where('is_active', false)->count();
        }

        return view('dashboard', compact(
            'sellerPendingOrdersCount',
            'sellerActiveProductsCount',
            'buyerRecentOrders',
            'buyerWishlist',
            'buyerOrdersCount',
            'buyerWishlistCount',
            'moderatorPendingReviewsCount',
            'moderatorSuspendedUsersCount',
            'moderatorSuspendedProductsCount'
        ));
    }
}
