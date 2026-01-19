<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Admin
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'admin'])->name('dashboard');

// User
Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'admin'])->name('home');

// User Dashboard
Route::get('/user/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('user.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('/products', ProductController::class)->middleware(['auth', 'verified', 'admin']);

Route::resource('/category', CategoryController::class)->middleware(['auth', 'verified', 'admin']);


require __DIR__ . '/auth.php';
