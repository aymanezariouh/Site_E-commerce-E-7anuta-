<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }


    /**
     * Dashboard avec statistiques globales
     */
    public function dashboard()
    {
        $usersByRole = DB::table('roles')
            ->leftJoin('model_has_roles', function ($join) {
                $join->on('roles.id', '=', 'model_has_roles.role_id')
                    ->where('model_has_roles.model_type', '=', User::class);
            })
            ->select('roles.name as role', DB::raw('COUNT(model_has_roles.model_id) as count'))
            ->groupBy('roles.name')
            ->get();


        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_reviews' => Review::count(),
            'pending_reviews' => Review::where('status', 'pending')->count(),
            'recent_orders' => Order::with('user')
                ->latest()
                ->take(5)
                ->get(),
            'revenue' => Order::whereIn('status', ['delivered'])
                ->sum('total_amount'),

            'users_by_role' => $usersByRole,
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Gestion des utilisateurs - Liste
     */
    public function users()
    {
        $users = User::with('roles')->latest()->paginate(20);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Afficher un utilisateur spécifique
     */
    public function showUser(User $user)
    {
        $user->load(['roles', 'orders', 'products', 'reviews']);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Mettre à jour le rôle d'un utilisateur
     */
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|string|in:buyer,seller,moderator,admin',
        ]);

        // Sync Spatie roles
        $user->syncRoles([$request->role]);

        return redirect()
            ->back()
            ->with('success', "Rôle de {$user->name} mis à jour avec succès.");
    }

    /**
     * Suspendre/Activer un utilisateur
     */
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


    /**
     * Supprimer définitivement un utilisateur
     */
    public function deleteUser(User $user)
    {
        $name = $user->name;
        $user->forceDelete();

        return redirect()
            ->route('admin.users')
            ->with('success', "Utilisateur {$name} supprimé définitivement.");
    }

    /**
     * Gestion des produits - Liste
     */
    public function products()
    {
        $products = Product::with('user', 'category')
            ->latest()
            ->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Modérer un produit (approuver/rejeter)
     */
    public function moderateProduct(Request $request, Product $product)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
            'reason' => 'nullable|string|max:500',
        ]);

        $product->update([
            'status' => $request->status,
            'moderation_reason' => $request->reason,
        ]);

        return redirect()
            ->back()
            ->with('success', "Produit {$product->name} modéré avec succès.");
    }

    /**
     * Supprimer un produit
     */
    public function deleteProduct(Product $product)
    {
        $name = $product->name;
        $product->delete();

        return redirect()
            ->back()
            ->with('success', "Produit {$name} supprimé.");
    }

    /**
     * Gestion des avis - Liste
     */
    public function reviews()
    {
        $reviews = Review::with('user', 'product')
            ->latest()
            ->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Avis en attente de modération
     */
    public function pendingReviews()
    {
        $reviews = Review::with('user', 'product')
            ->where('status', 'pending')
            ->latest()
            ->paginate(20);

        return view('admin.reviews.pending', compact('reviews'));
    }

    /**
     * Modérer un avis
     */
    public function moderateReview(Request $request, Review $review)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
            'reason' => 'nullable|string|max:500',
        ]);

        $review->update([
            'status' => $request->status,
            'moderation_reason' => $request->reason,
        ]);

        return redirect()
            ->back()
            ->with('success', "Avis modéré avec succès.");
    }

    /**
     * Supprimer un avis
     */
    public function deleteReview(Review $review)
    {
        $review->delete();

        return redirect()
            ->back()
            ->with('success', 'Avis supprimé avec succès.');
    }

    /**
     * Gestion des commandes - Liste
     */
    public function orders()
    {
        $orders = Order::with('user', 'items.product')
            ->latest()
            ->paginate(20);

        return view('admin.orders', compact('orders'));
    }

    /**
     * Afficher une commande spécifique
     */
    public function showOrder(Order $order)
    {
        $order->load(['user', 'items.product', 'payments']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Mettre à jour le statut d'une commande
     */
    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled,refunded',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()
            ->back()
            ->with('success', "Statut de la commande #{$order->id} mis à jour.");
    }

    /**
     * Statistiques détaillées
     */
    public function statistics()
    {
        $stats = [
            // Statistiques des ventes
            'sales' => [
                'today' => Order::whereDate('created_at', today())->sum('total_amount'),
                'week' => Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_amount'),
                'month' => Order::whereMonth('created_at', now()->month)->sum('total_amount'),
                'year' => Order::whereYear('created_at', now()->year)->sum('total_amount'),
            ],

            // Top produits
            'top_products' => Product::withCount('orderItems')
                ->orderBy('order_items_count', 'desc')
                ->take(10)
                ->get(),

            // Top vendeurs
            'top_sellers' => User::role('seller')
                ->withCount('products')
                ->orderBy('products_count', 'desc')
                ->take(10)
                ->get(),

            // Tendances mensuelles
            'monthly_orders' => Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total_amount) as revenue')
            )
                ->whereYear('created_at', now()->year)
                ->groupBy('month')
                ->get(),
        ];

        return view('admin.statistics', compact('stats'));
    }
}
