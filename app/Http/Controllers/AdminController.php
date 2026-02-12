<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Review;
use App\Notifications\AdminAlertNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|moderator']);
        $this->middleware('role:admin')->only([
            'dashboard',
            'statistics',
            'updateUserRole',
            'deleteUser',
            'deleteProduct',
            'deleteReview',
            'orders',
            'showOrder',
            'updateOrderStatus',
        ]);
    }
public function dashboard()
    {
        $currentMonth = now()->startOfMonth();
        $previousMonth = now()->subMonth()->startOfMonth();
        $previousMonthEnd = now()->subMonth()->endOfMonth();
        $currentUsersCount = User::whereDate('created_at', '>=', $currentMonth)->count();
        $previousUsersCount = User::whereBetween('created_at', [$previousMonth, $previousMonthEnd])->count();
        $totalUsers = User::count();
        $usersChange = $this->calculatePercentageChange($currentUsersCount, $previousUsersCount);
        $currentProductsCount = Product::whereDate('created_at', '>=', $currentMonth)->count();
        $previousProductsCount = Product::whereBetween('created_at', [$previousMonth, $previousMonthEnd])->count();
        $totalProducts = Product::where('is_active', true)->count();
        $productsChange = $this->calculatePercentageChange($currentProductsCount, $previousProductsCount);
        $currentOrdersCount = Order::whereDate('created_at', '>=', $currentMonth)->count();
        $previousOrdersCount = Order::whereBetween('created_at', [$previousMonth, $previousMonthEnd])->count();
        $totalOrders = Order::count();
        $ordersChange = $this->calculatePercentageChange($currentOrdersCount, $previousOrdersCount);
        $currentRevenue = Order::whereDate('created_at', '>=', $currentMonth)
            ->whereIn('status', ['delivered', 'processing', 'shipped'])
            ->sum('total_amount');
        $previousRevenue = Order::whereBetween('created_at', [$previousMonth, $previousMonthEnd])
            ->whereIn('status', ['delivered', 'processing', 'shipped'])
            ->sum('total_amount');
        $totalRevenue = Order::whereIn('status', ['delivered', 'processing', 'shipped'])
            ->sum('total_amount');
        $revenueChange = $this->calculatePercentageChange($currentRevenue, $previousRevenue);
        $usersByRole = DB::table('roles')
            ->leftJoin('model_has_roles', function ($join) {
                $join->on('roles.id', '=', 'model_has_roles.role_id')
                    ->where('model_has_roles.model_type', '=', User::class);
            })
            ->select('roles.name as role', DB::raw('COUNT(model_has_roles.model_id) as count'))
            ->groupBy('roles.name')
            ->get();

        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        $pendingReviews = Review::where('moderation_status', 'pending')->count();
        $totalReviews = Review::count();

        // Build recent activity feed
        $recentActivity = collect();
        
        // Add recent orders
        foreach (Order::with('user')->latest()->take(10)->get() as $order) {
            $recentActivity->push((object)[
                'type' => 'order',
                'description' => "Commande #{$order->id} créée par {$order->user->name}",
                'created_at' => $order->created_at,
            ]);
        }
        
        // Add recent users
        foreach (User::latest()->take(5)->get() as $user) {
            $recentActivity->push((object)[
                'type' => 'user',
                'description' => "Nouvel utilisateur {$user->name}",
                'created_at' => $user->created_at,
            ]);
        }
        
        // Add recent products
        foreach (Product::latest()->take(5)->get() as $product) {
            $recentActivity->push((object)[
                'type' => 'product',
                'description' => "Nouveau produit : {$product->name}",
                'created_at' => $product->created_at,
            ]);
        }
        
        // Sort by creation date and take the latest 10
        $recentActivity = $recentActivity->sortByDesc('created_at')->take(10)->values();

        $stats = [
            'users' => $totalUsers,
            'users_change' => [
                'percentage' => abs($usersChange),
                'type' => $usersChange >= 0 ? 'increase' : 'decrease',
                'period' => 'ce mois'
            ],
            'products' => $totalProducts,
            'products_change' => [
                'percentage' => abs($productsChange),
                'type' => $productsChange >= 0 ? 'increase' : 'decrease',
                'period' => 'ce mois'
            ],
            'orders' => $totalOrders,
            'orders_change' => [
                'percentage' => abs($ordersChange),
                'type' => $ordersChange >= 0 ? 'increase' : 'decrease',
                'period' => 'ce mois'
            ],
            'revenue' => $totalRevenue,
            'revenue_change' => [
                'percentage' => abs($revenueChange),
                'type' => $revenueChange >= 0 ? 'increase' : 'decrease',
                'period' => 'ce mois'
            ],
            'pending_reviews' => $pendingReviews,
            'total_reviews' => $totalReviews,
            'recent_orders' => $recentOrders,
            'users_by_role' => $usersByRole,
        ];

        return view('admin.dashboard', compact('stats', 'recentActivity'));
    }
private function calculatePercentageChange($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return (($current - $previous) / $previous) * 100;
    }
public function users()
    {
        $users = User::with('roles')->latest()->paginate(20);
        $roles = Role::all();

        return view('admin.users', compact('users', 'roles'));
    }
public function showUser(User $user)
    {
        $user->load(['roles', 'orders', 'products', 'reviews']);

        return view('admin.users.show', compact('user'));
    }
public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|string|in:buyer,seller,moderator,admin',
        ]);
        $user->syncRoles([$request->role]);

        return redirect()
            ->back()
            ->with('success', "Rôle de {$user->name} mis à jour avec succès.");
    }
public function toggleUserStatus(User $user)
    {
        if ($user->trashed()) {
            $user->restore();
            $message = "Utilisateur {$user->name} activé.";
        } else {
            $user->delete();
            $message = "Utilisateur {$user->name} suspendu.";
        }

        return back()->with('success', $message);
    }
public function deleteUser(User $user)
    {
        $name = $user->name;
        $user->forceDelete();

        return redirect()
            ->route('admin.users')
            ->with('success', "Utilisateur {$name} supprimé définitivement.");
    }
public function products()
    {
        $products = Product::with('user', 'category')
            ->latest()
            ->paginate(20);

        return view('admin.products', compact('products'));
    }
public function moderateProduct(Request $request, Product $product)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending,suspended',
            'reason' => 'nullable|string|max:500',
        ]);

        $product->update([
            'moderation_status' => $request->status,
            'moderation_reason' => $request->reason,
        ]);

        return redirect()
            ->back()
            ->with('success', "Produit {$product->name} modéré avec succès.");
    }
public function deleteProduct(Product $product)
    {
        $name = $product->name;
        $product->delete();

        return redirect()
            ->back()
            ->with('success', "Produit {$name} supprimé.");
    }
public function reviews()
    {
        $reviews = Review::with('user', 'product')
            ->latest()
            ->paginate(20);

        return view('admin.reviews', compact('reviews'));
    }
public function pendingReviews()
    {
        $reviews = Review::with('user', 'product')
            ->where('moderation_status', 'pending')
            ->latest()
            ->paginate(20);

        return view('admin.reviews.pending', compact('reviews'));
    }
public function moderateReview(Request $request, Review $review)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending,suspended',
            'reason' => 'nullable|string|max:500',
        ]);

        $review->update([
            'moderation_status' => $request->status,
            'moderation_reason' => $request->reason,
        ]);

        return redirect()
            ->back()
            ->with('success', "Avis modéré avec succès.");
    }
public function deleteReview(Review $review)
    {
        $review->delete();

        return redirect()
            ->back()
            ->with('success', 'Avis supprimé avec succès.');
    }
public function orders()
    {
        $orders = Order::with('user', 'items.product')
            ->latest()
            ->paginate(20);

        return view('admin.orders', compact('orders'));
    }
public function showOrder(Order $order)
    {
        $order->load(['user', 'items.product', 'payments']);

        return view('admin.orders.show', compact('order'));
    }
public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled,refunded',
        ]);

        $order->update(['status' => $request->status]);

        $admins = User::role('admin')->whereKeyNot(Auth::id())->get();
        if ($admins->isNotEmpty()) {
            Notification::send(
                $admins,
                new AdminAlertNotification(
                    'order_status_changed',
                    'Statut de commande #' . $order->order_number . ' mis a jour: ' . $order->status,
                    route('admin.orders.show', $order)
                )
            );
        }

        return redirect()
            ->back()
            ->with('success', "Statut de la commande #{$order->id} mis à jour.");
    }
public function statistics()
    {
        $totalRevenue = Order::whereIn('status', ['delivered', 'processing', 'shipped'])
            ->sum('total_amount');

        $totalOrders = Order::count();

        $newCustomers = User::whereDate('created_at', '>=', now()->subDays(30))
            ->count();

        $totalVisitors = User::count(); // Simplified - in production would track sessions
        $conversionRate = $totalVisitors > 0 ? ($totalOrders / $totalVisitors) * 100 : 0;
        $topProducts = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(10)
            ->get();
        $recentOrders = Order::with('user')
            ->latest()
            ->take(10)
            ->get();
        $salesData = [
            'labels' => [],
            'data' => []
        ];

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $salesData['labels'][] = $date->format('M d');
            $salesData['data'][] = Order::whereDate('created_at', $date->format('Y-m-d'))
                ->sum('total_amount');
        }
        $ordersData = [
            'labels' => ['Livrées', 'En cours', 'Annulées', 'En attente'],
            'data' => [
                Order::where('status', 'delivered')->count(),
                Order::whereIn('status', ['processing', 'shipped'])->count(),
                Order::where('status', 'cancelled')->count(),
                Order::where('status', 'pending')->count(),
            ]
        ];

        // KPIs array for the view
        $kpis = [
            'revenue' => $totalRevenue,
            'orders_count' => $totalOrders,
            'new_customers' => $newCustomers,
            'conversion_rate' => round($conversionRate, 2),
            'total_visitors' => $totalVisitors,
        ];

        // Charts data for the view
        $charts = [
            'sales' => $salesData,
            'orders' => $ordersData,
        ];

        return view('admin.statistics', compact(
            'kpis',
            'charts',
            'totalRevenue', 
            'totalOrders', 
            'newCustomers', 
            'conversionRate',
            'topProducts',
            'recentOrders',
            'salesData',
            'ordersData'
        ));
    }
}
