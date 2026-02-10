<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\SellerCategoryController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\SellerReviewController;
use App\Http\Controllers\SellerAnalyticsController;
use App\Http\Controllers\SellerNotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ModeratorController;

Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    if (Auth::user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }
    
    return redirect()->route('marketplace');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:buyer|seller|moderator'])
    ->name('dashboard');

// Public marketplace - accessible to everyone
Route::get('/marketplace', [BuyerController::class, 'index'])->name('marketplace');
Route::get('/marketplace/{id}', [BuyerController::class, 'show'])->name('marketplace.show');

// Protected marketplace actions - require auth
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/marketplace/{id}/add-to-cart', [BuyerController::class, 'addToCart'])->name('marketplace.addToCart');
    Route::post('/marketplace/{id}/review', [BuyerController::class, 'addReview'])->name('marketplace.addReview');
    Route::post('/marketplace/{id}/toggle-like', [BuyerController::class, 'toggleLike'])->name('marketplace.toggleLike');

    Route::get('/orders', function () {
        return view('orders');
    })->name('orders');
});

Route::middleware(['auth', 'verified', 'role:seller', 'seller.active'])->group(function () {
    // Stock & Products
    Route::get('/seller/stock', [SellerProductController::class, 'index'])->name('seller.stock');
    Route::get('/seller/products', [SellerProductController::class, 'index'])->name('seller.products.index');
    Route::get('/seller/products/create', [SellerProductController::class, 'create'])->name('seller.products.create');
    Route::post('/seller/products', [SellerProductController::class, 'store'])->name('seller.products.store');
    Route::get('/seller/products/{product}/edit', [SellerProductController::class, 'edit'])->name('seller.products.edit');
    Route::put('/seller/products/{product}', [SellerProductController::class, 'update'])->name('seller.products.update');
    Route::patch('/seller/products/{product}/stock', [SellerProductController::class, 'adjustStock'])->name('seller.products.adjustStock');
    Route::delete('/seller/products/{product}', [SellerProductController::class, 'destroy'])->name('seller.products.destroy');

    // Categories
    Route::get('/seller/categories', [SellerCategoryController::class, 'index'])->name('seller.categories.index');
    Route::get('/seller/categories/create', [SellerCategoryController::class, 'create'])->name('seller.categories.create');
    Route::post('/seller/categories', [SellerCategoryController::class, 'store'])->name('seller.categories.store');
    Route::get('/seller/categories/{category}/edit', [SellerCategoryController::class, 'edit'])->name('seller.categories.edit');
    Route::put('/seller/categories/{category}', [SellerCategoryController::class, 'update'])->name('seller.categories.update');
    Route::delete('/seller/categories/{category}', [SellerCategoryController::class, 'destroy'])->name('seller.categories.destroy');

    // Orders
    Route::get('/seller/orders', [SellerOrderController::class, 'index'])->name('seller.orders');
    Route::get('/seller/orders/{order}', [SellerOrderController::class, 'show'])->name('seller.orders.show');
    Route::patch('/seller/orders/{order}/status', [SellerOrderController::class, 'updateStatus'])->name('seller.orders.updateStatus');

    
    Route::get('/seller/reviews', [SellerReviewController::class, 'index'])->name('seller.reviews');

    
    Route::get('/seller/analytics', [SellerAnalyticsController::class, 'index'])->name('seller.analytics');

    
    Route::get('/seller/notifications', [SellerNotificationController::class, 'index'])->name('seller.notifications');
    Route::patch('/seller/notifications/{id}/read', [SellerNotificationController::class, 'markAsRead'])->name('seller.notifications.markAsRead');
    Route::patch('/seller/notifications/read-all', [SellerNotificationController::class, 'markAllAsRead'])->name('seller.notifications.markAllAsRead');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'role:buyer'])->group(function() {
    Route::get('/cart', [BuyerController::class, 'cart'])->name('buyer.cart');
    Route::get('/checkout', [BuyerController::class, 'checkout'])->name('buyer.checkout');
    Route::post('/place-order', [BuyerController::class, 'placeOrder'])->name('buyer.placeOrder');
    Route::get('/buyer/orders', [BuyerController::class, 'orders'])->name('buyer.orders');
    Route::get('/buyer/orders/{id}', [BuyerController::class, 'orderDetails'])->name('buyer.orderDetails');
});

// Route temporaire pour tester changement de statut
Route::get('/test-order-status/{orderId}/{status}', function($orderId, $status) {
    $order = \App\Models\Order::findOrFail($orderId);
    $order->update(['status' => $status]);
    return redirect()->route('buyer.orders')->with('success', 'Order status changed to ' . $status . '. Check storage/logs/laravel.log for email!');
})->middleware('auth')->name('test.orderStatus');

// Test user roles
Route::get('/test-roles', function() {
    $user = Auth::user();
    return [
        'user_id' => $user->id,
        'name' => $user->name,
        'roles' => $user->roles->pluck('name'),
        'has_buyer_role' => $user->hasRole('buyer'),
        'has_moderator_role' => $user->hasRole('moderator'),
    ];
})->middleware('auth');

// Routes Moderator
Route::middleware(['auth', 'verified', 'role:moderator'])
    ->prefix('moderator')
    ->name('moderator.')
    ->group(function () {
        Route::get('/reviews', [ModeratorController::class, 'reviews'])->name('reviews');
        Route::patch('/reviews/{id}/hide', [ModeratorController::class, 'hideReview'])->name('reviews.hide');
        Route::patch('/reviews/{id}/show', [ModeratorController::class, 'showReview'])->name('reviews.show');
        Route::delete('/reviews/{id}', [ModeratorController::class, 'deleteReview'])->name('reviews.delete');
        
        Route::get('/users', [ModeratorController::class, 'users'])->name('users');
        Route::patch('/users/{id}/suspend', [ModeratorController::class, 'suspendUser'])->name('users.suspend');
        Route::patch('/users/{id}/unsuspend', [ModeratorController::class, 'unsuspendUser'])->name('users.unsuspend');
        
        Route::get('/products', [ModeratorController::class, 'products'])->name('products');
        Route::patch('/products/{id}/suspend', [ModeratorController::class, 'suspendProduct'])->name('products.suspend');
        Route::patch('/products/{id}/unsuspend', [ModeratorController::class, 'unsuspendProduct'])->name('products.unsuspend');
    });

// Routes Admin
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {    // Dashboard & Statistiques
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');

    // Gestion des utilisateurs
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::patch('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.update-role');
    Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');

    // Modération des produits
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::patch('/products/{product}/moderate', [AdminController::class, 'moderateProduct'])->name('products.moderate');
    Route::delete('/products/{product}', [AdminController::class, 'deleteProduct'])->name('products.delete');

    // Modération des avis
    Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews');
    Route::get('/reviews/pending', [AdminController::class, 'pendingReviews'])->name('reviews.pending');
    Route::patch('/reviews/{review}/moderate', [AdminController::class, 'moderateReview'])->name('reviews.moderate');
    Route::delete('/reviews/{review}', [AdminController::class, 'deleteReview'])->name('reviews.delete');

    // Gestion des commandes
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.update-status');
});

Route::post('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');


require __DIR__ . '/auth.php';
