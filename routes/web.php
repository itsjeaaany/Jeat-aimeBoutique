<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\ShopController;
use App\Http\Middleware\EnsureRole;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/products/{product}', [ShopController::class, 'show'])->name('shop.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [\App\Http\Controllers\CartController::class, 'index'])->name('index');
        Route::post('add/{product}', [\App\Http\Controllers\CartController::class, 'add'])->name('add');
        Route::patch('{cart}', [\App\Http\Controllers\CartController::class, 'update'])->name('update');
        Route::delete('{cart}', [\App\Http\Controllers\CartController::class, 'remove'])->name('remove');
        Route::get('checkout', [\App\Http\Controllers\CartController::class, 'showCheckout'])->name('checkout');
        Route::post('process-checkout', [\App\Http\Controllers\CartController::class, 'processCheckout'])->name('process-checkout');
    });

    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('{order}', [OrderController::class, 'show'])->name('show');
        Route::post('product/{product}', [OrderController::class, 'store'])->name('store');
        Route::patch('{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
        Route::get('checkout/product/{product}', [OrderController::class, 'checkoutDirect'])->name('checkout.direct');
        Route::post('process-checkout-direct', [OrderController::class, 'processDirectCheckout'])->name('process-checkout-direct');
    });
});

Route::middleware(['auth', EnsureRole::class . ':seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::resource('products', ProductController::class)->except(['show']);
    Route::resource('orders', SellerOrderController::class)->only(['index', 'show', 'update']);
});

require __DIR__.'/auth.php';
