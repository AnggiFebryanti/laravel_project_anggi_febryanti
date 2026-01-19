<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/products', ProductController::class);
    Route::resource('/category', CategoryController::class);
});

// User Routes
Route::middleware(['auth', 'verified', 'user'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/user/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');

    // Product routes for users
    Route::get('/produk', [ProductController::class, 'userIndex'])->name('products.userIndex');
    Route::get('/produk/{id}', [ProductController::class, 'userShow'])->name('products.userShow');

    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product_id}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{product_id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{product_id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    // Order routes
    Route::get('/orders', [CheckoutController::class, 'orderHistory'])->name('orders.index');
    Route::get('/orders/{order_id}', [CheckoutController::class, 'orderDetail'])->name('orders.show');
});

// Common Routes (accessible by all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
