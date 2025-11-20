<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Admin
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'admin'])->name('dashboard');

// User
Route::get('/', function () {
    return view('user.home');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {
    return view('home');
})->name('home');

Route::resource('/products', ProductController::class)->middleware(['auth', 'verified', 'admin']);

Route::resource('/category', CategoryController::class)->middleware(['auth', 'verified', 'admin']);


require __DIR__ . '/auth.php';
