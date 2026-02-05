<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\AdminController;

// Redirect root to dashboard or login
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// Dashboard for authenticated users (buyers, sellers, moderators)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:buyer|seller|moderator'])
    ->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Buyer routes (changed from 'client' to 'buyer')
Route::middleware(['auth', 'role:buyer'])->group(function() {
    Route::get('/produits', [BuyerController::class, 'index'])->name('buyer.produits');
    Route::get('/produits/{id}', [BuyerController::class, 'show'])->name('buyer.produits.show');
    Route::post('/produits/{id}/add-to-cart', [BuyerController::class, 'addToCart'])->name('buyer.addToCart');
    Route::get('/mes-commandes', [BuyerController::class, 'orders'])->name('buyer.orders');
});

// Routes Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard & Statistiques
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


require __DIR__.'/auth.php';
