<?php

use App\Http\Controllers\CategoryController;
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
});

// Common Routes (accessible by all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
