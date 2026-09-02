<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'role:manager,admin'])->name('dashboard');

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
    
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';