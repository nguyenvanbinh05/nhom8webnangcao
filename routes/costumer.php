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

Route::get('/menu', function () {
    return view('costumer.menu');
})->name('menu');

Route::get('/san-pham', function () {
    return view('costumer.product-detail');
})->name('product-detail');

Route::get('/gio-hang', function () {
    return view('costumer.cart');
})->name('cart');

Route::get('/thanhtoan', function () {
    return view('costumer.checkout');
})->name('checkout');
