<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerAnalyticsController extends Controller
{
    /**
     * Display seller analytics dashboard.
     */
    public function index()
    {
        $sellerId = Auth::id();

        // Get seller's product IDs
        $productIds = Product::where('user_id', $sellerId)->pluck('id');

        // Total sales amount from order items
        $totalSales = OrderItem::whereIn('product_id', $productIds)
            ->whereHas('order', function ($query) {
                $query->whereIn('status', ['processing', 'shipped', 'delivered']);
            })
            ->sum('total_price');

        // Total orders containing seller's products
        $totalOrders = Order::whereHas('items', function ($query) use ($productIds) {
            $query->whereIn('product_id', $productIds);
        })->count();

        // Orders by status
        $ordersByStatus = Order::whereHas('items', function ($query) use ($productIds) {
            $query->whereIn('product_id', $productIds);
        })
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Top 5 selling products
        $topProducts = Product::where('user_id', $sellerId)
            ->withCount(['orderItems as sold_quantity' => function ($query) {
                $query->select(DB::raw('COALESCE(SUM(quantity), 0)'));
            }])
            ->withSum(['orderItems as revenue' => function ($query) {
                $query->whereHas('order', function ($q) {
                    $q->whereIn('status', ['processing', 'shipped', 'delivered']);
                });
            }], 'total_price')
            ->orderByDesc('sold_quantity')
            ->take(5)
            ->get();

        // Stock alerts (products with stock <= 5)
        $lowStockCount = Product::where('user_id', $sellerId)
            ->where('stock_quantity', '<=', 5)
            ->count();

        $totalProducts = Product::where('user_id', $sellerId)->count();
        $stockAlertRate = $totalProducts > 0 
            ? round(($lowStockCount / $totalProducts) * 100, 1) 
            : 0;

        // Average rating across all seller's products
        $averageRating = Review::whereIn('product_id', $productIds)
            ->where('moderation_status', 'approved')
            ->avg('rating') ?? 0;

        // Total reviews
        $totalReviews = Review::whereIn('product_id', $productIds)->count();

        // Sales by month (last 6 months)
        $monthlySales = OrderItem::whereIn('product_id', $productIds)
            ->whereHas('order', function ($query) {
                $query->whereIn('status', ['processing', 'shipped', 'delivered'])
                    ->where('created_at', '>=', now()->subMonths(6));
            })
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select(
                DB::raw('YEAR(orders.created_at) as year'),
                DB::raw('MONTH(orders.created_at) as month'),
                DB::raw('SUM(order_items.total_price) as total')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return view('seller.analytics', compact(
            'totalSales',
            'totalOrders',
            'ordersByStatus',
            'topProducts',
            'lowStockCount',
            'stockAlertRate',
            'averageRating',
            'totalReviews',
            'monthlySales',
            'totalProducts'
        ));
    }
}
