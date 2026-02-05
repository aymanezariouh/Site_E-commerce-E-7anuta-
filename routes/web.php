<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\SellerCategoryController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\SellerReviewController;
use App\Http\Controllers\SellerAnalyticsController;
use App\Http\Controllers\SellerNotificationController;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified', 'role:admin'])->name('admin.dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/marketplace', function () {
        $mockProducts = collect(range(1, 28))->map(function (int $index) {
            return [
                'name' => "Produit {$index}",
                'category' => $index % 3 === 0 ? 'Mode' : ($index % 2 === 0 ? 'Tech' : 'Maison'),
                'price' => number_format(9 + ($index * 2), 2),
                'badge' => $index % 4 === 0 ? 'Promo' : ($index % 3 === 0 ? 'Top vente' : 'Nouveau'),
                'summary' => 'Description rapide du produit.',
            ];
        });

        return view('buyer.marketplace', ['products' => $mockProducts]);
    })->name('marketplace');

    Route::get('/orders', function () {
        return view('orders');
    })->name('orders');
});

Route::middleware(['auth', 'verified', 'role:seller'])->group(function () {
    // Stock & Products
    Route::get('/seller/stock', [SellerProductController::class, 'index'])->name('seller.stock');
    Route::get('/seller/products', [SellerProductController::class, 'index'])->name('seller.products.index');
    Route::get('/seller/products/create', [SellerProductController::class, 'create'])->name('seller.products.create');
    Route::post('/seller/products', [SellerProductController::class, 'store'])->name('seller.products.store');
    Route::get('/seller/products/{product}/edit', [SellerProductController::class, 'edit'])->name('seller.products.edit');
    Route::put('/seller/products/{product}', [SellerProductController::class, 'update'])->name('seller.products.update');
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

    // Reviews
    Route::get('/seller/reviews', [SellerReviewController::class, 'index'])->name('seller.reviews');

    // Analytics
    Route::get('/seller/analytics', [SellerAnalyticsController::class, 'index'])->name('seller.analytics');

    // Notifications
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
    Route::get('/products', [BuyerController::class, 'index'])->name('buyer.produits');
    Route::get('/products/{id}', [BuyerController::class, 'show'])->name('buyer.produits.show');
    Route::post('/products/{id}/add-to-cart', [BuyerController::class, 'addToCart'])->name('buyer.addToCart');
    Route::get('/cart', [BuyerController::class, 'cart'])->name('buyer.cart');
    Route::get('/checkout', [BuyerController::class, 'checkout'])->name('buyer.checkout');
    Route::post('/place-order', [BuyerController::class, 'placeOrder'])->name('buyer.placeOrder');
    Route::get('/buyer/orders', [BuyerController::class, 'orders'])->name('buyer.orders');
    Route::get('/buyer/orders/{id}', [BuyerController::class, 'orderDetails'])->name('buyer.orderDetails');
    Route::post('/products/{id}/review', [BuyerController::class, 'addReview'])->name('buyer.addReview');
    Route::post('/products/{id}/toggle-like', [BuyerController::class, 'toggleLike'])->name('buyer.toggleLike');
});

Route::middleware(['auth', 'role:admin'])->group(function() {
    Route::get('/admin/orders', [App\Http\Controllers\AdminController::class, 'orders'])->name('admin.orders');
    Route::patch('/admin/orders/{id}/status', [App\Http\Controllers\AdminController::class, 'updateOrderStatus'])->name('admin.updateOrderStatus');
});


require __DIR__.'/auth.php';
