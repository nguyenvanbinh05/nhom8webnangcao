<?php

use Illuminate\Support\Facades\Route;

// Route::middleware(['auth', 'role:customer'])->group(function () {

//     Route::get('/', function () {
//         return view('costumer.home');
//     })->name('home');

//     Route::get('/menu', function () {
//         return view('costumer.menu');
//     })->name('menu');

//     Route::get('/san-pham', function () {
//         return view('costumer.product-detail');
//     })->name('product-detail');

//     Route::get('/gio-hang', function () {
//         return view('costumer.cart');
//     })->name('cart');

//     Route::get('/thanhtoan', function () {
//         return view('costumer.checkout');
//     })->name('checkout');
// });

// Route::get('/menu', function () {
//     return view('costumer.menu');
// })->name('menu');

use App\Http\Controllers\MenuController;

Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

Route::get('/menu/category/{idCategory}', [MenuController::class, 'byCategory'])
    ->whereNumber('idCategory')
    ->name('menu.byCategory');

// routes/web.php
use App\Http\Controllers\CartController;

Route::get('/cart',           [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add',      [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update',   [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove',   [CartController::class, 'remove'])->name('cart.remove');

// Route::get('/san-pham', function () {
//     return view('costumer.product-detail');
// })->name('product-detail');

// Route::get('/gio-hang', function () {
//     return view('costumer.cart');
// })->name('cart');

// Route::get('/thanhtoan', function () {
//     return view('customer.checkout');
// })->name('checkout');

// routes/web.php
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderHistoryController;

// Thanh toán (bắt buộc đăng nhập & đã xác thực email)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/checkout',  [CheckoutController::class, 'show'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'place'])->name('checkout.place');

    // Lịch sử đơn hàng
    Route::get('/orders',     [OrderHistoryController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderHistoryController::class, 'show'])->name('orders.show');
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
