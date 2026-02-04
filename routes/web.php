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

        $perPage = 12; // 4 rows * 3 columns
        $page = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $items = $mockProducts->forPage($page, $perPage)->values();
        $products = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $mockProducts->count(),
            $perPage,
            $page,
            ['path' => route('marketplace')]
        );

        return view('buyer.marketplace', ['products' => $products]);
    })->name('marketplace');

    Route::get('/orders', function () {
        return view('buyer.orders');
    })->name('orders');
});

Route::middleware(['auth', 'verified', 'role:seller'])->group(function () {
    Route::get('/seller/stock', function () {
        return view('seller.stock');
    })->name('seller.stock');

    Route::get('/seller/orders', function () {
        return view('seller.orders');
    })->name('seller.orders');

    Route::get('/seller/order-details', function () {
        return view('seller.order-details');
    })->name('seller.order-details');

    Route::get('/seller/reviews', function () {
        return view('seller.reviews');
    })->name('seller.reviews');

    Route::get('/seller/analytics', function () {
        return view('seller.analytics');
    })->name('seller.analytics');

    Route::get('/seller/notifications', function () {
        return view('seller.notifications');
    })->name('seller.notifications');
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
    Route::get('/orders', [BuyerController::class, 'orders'])->name('buyer.orders');
    Route::get('/orders/{id}', [BuyerController::class, 'orderDetails'])->name('buyer.orderDetails');
    Route::post('/products/{id}/review', [BuyerController::class, 'addReview'])->name('buyer.addReview');
});


require __DIR__.'/auth.php';