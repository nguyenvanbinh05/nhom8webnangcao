<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// route cho admin
Route::get('/admin', [PageController::class, 'homePage'])->name('homePage');
Route::get('/admin/product-management', [PageController::class, 'productManagement'])->name('productManagement');
Route::get('/admin/product-management/add', [PageController::class, 'productAdd'])->name('productAdd');
Route::get('/admin/account-management', [PageController::class, 'accountManagement'])->name('accountManagement');
Route::get('/admin/category-management', [PageController::class, 'categoryManagement'])->name('categoryManagement');
Route::get('/admin/point-of-sale', [PageController::class, 'pos'])->name('pos');


use App\Http\Controllers\SupplierController;
use App\Http\Controllers\IngredientController;

// quản lý nhà cung cấp
Route::resource('supplier', SupplierController::class);

// quản lý kho nguyên liệu
Route::resource('ingredients', IngredientController::class);