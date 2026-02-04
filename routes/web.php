<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BuyerController;

Route::middleware(['auth'])->group(function () {

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


});
Route::get('/', function () {
    return view('welcome');
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




Route::middleware(['auth', 'role:client'])->group(function() {
    Route::get('/produits', [BuyerController::class, 'index'])->name('buyer.produits');
    Route::get('/produits/{id}', [BuyerController::class, 'show'])->name('buyer.produits.show');
    Route::post('/produits/{id}/add-to-cart', [BuyerController::class, 'addToCart'])->name('buyer.addToCart');
    Route::get('/mes-commandes', [BuyerController::class, 'orders'])->name('buyer.orders');
});


require __DIR__.'/auth.php';
