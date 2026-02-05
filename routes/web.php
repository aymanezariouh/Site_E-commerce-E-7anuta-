<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BuyerController;

Route::middleware(['auth'])->group(function () {

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


});
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'role:buyer|seller|moderator'])->name('dashboard');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified', 'role:admin'])->name('admin.dashboard');

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
    Route::get('/orders', [BuyerController::class, 'orders'])->name('buyer.orders');
    Route::get('/orders/{id}', [BuyerController::class, 'orderDetails'])->name('buyer.orderDetails');
    Route::post('/products/{id}/review', [BuyerController::class, 'addReview'])->name('buyer.addReview');
    Route::post('/products/{id}/toggle-like', [BuyerController::class, 'toggleLike'])->name('buyer.toggleLike');
});

Route::middleware(['auth', 'role:admin'])->group(function() {
    Route::get('/admin/orders', [App\Http\Controllers\AdminController::class, 'orders'])->name('admin.orders');
    Route::patch('/admin/orders/{id}/status', [App\Http\Controllers\AdminController::class, 'updateOrderStatus'])->name('admin.updateOrderStatus');
});


require __DIR__.'/auth.php';