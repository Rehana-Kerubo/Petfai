<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'role:manager,admin'])->name('dashboard');

// sales agent
Route::get('/sales', [SalesController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:sales,manager,admin'])
    ->name('sales.index');

Route::post('/sales/cart/add/{product}', [SalesController::class, 'addToCart'])
    ->middleware(['auth', 'verified', 'role:sales,manager,admin'])
    ->name('cart.add');

Route::post('/sales/cart/remove/{product}', [SalesController::class, 'removeFromCart'])
    ->middleware(['auth', 'verified', 'role:sales,manager,admin'])
    ->name('cart.remove');

Route::post('/sales/cart/update/{product}', [SalesController::class, 'updateCartQuantity'])
    ->middleware(['auth', 'verified', 'role:sales,manager,admin'])
    ->name('cart.update');     
Route::post('/sales/checkout', [SalesController::class, 'checkout'])
    ->middleware(['auth', 'verified', 'role:sales,manager,admin'])
    ->name('sales.checkout');

Route::get('/sales/receipt/{sale}', [SalesController::class, 'receipt'])
    ->middleware(['auth', 'verified', 'role:sales,manager,admin'])
    ->name('sales.receipt');

// dashboard for manager and admin
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:manager,admin'])
    ->name('dashboard');

// product management for manager and admin
Route::get('/products', [ProductController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:manager,admin'])
    ->name('products.index');

Route::patch('/products/{product}', [ProductController::class, 'update'])
    ->middleware(['auth', 'verified', 'role:manager,admin'])
    ->name('products.update');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// user management for manager and admin
Route::get('/users', [UserController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:manager,admin'])
    ->name('users.index');

Route::post('/users', [UserController::class, 'store'])
    ->middleware(['auth', 'verified', 'role:manager,admin'])
    ->name('users.store');

Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])
    ->middleware(['auth', 'verified', 'role:manager,admin'])
    ->name('users.toggleActive');

require __DIR__.'/auth.php';