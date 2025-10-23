<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

Route::get('/menu/category/{idCategory}', [MenuController::class, 'byCategory'])
    ->whereNumber('idCategory')
    ->name('menu.byCategory');

use App\Http\Controllers\CartController;

Route::get('/cart',           [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add',      [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update',   [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove',   [CartController::class, 'remove'])->name('cart.remove');

use App\Http\Controllers\CheckoutController;


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/checkout',  [CheckoutController::class, 'show'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'place'])->name('checkout.place');
});

use App\Http\Controllers\AccountController;

Route::middleware(['auth', 'verified'])->prefix('account')->name('account.')->group(function () {
    Route::get('/',               [AccountController::class, 'overview'])->name('overview');
    Route::get('/orders',         [AccountController::class, 'orders'])->name('orders');
    Route::get('/orders/{order:idOrder}', [AccountController::class, 'orderShow'])->name('orders.show');
    Route::get('/password',       [AccountController::class, 'passwordForm'])->name('password.form');
    Route::put('/password',      [AccountController::class, 'passwordUpdate'])->name('password.update');
});

// routes/web.php
use App\Http\Controllers\ContactController;

Route::post('/contact/send', [ContactController::class, 'send'])
    ->name('contact.send')
    ->middleware('throttle:5,1');

// routes/web.php
use App\Http\Controllers\ProductController;

Route::get('/product/{idProduct}', [ProductController::class, 'show'])
    ->whereNumber('idProduct')
    ->name('product.show');
