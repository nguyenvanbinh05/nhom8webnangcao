<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// route cho admin
Route::get('/admin', [PageController::class, 'homePage'])->name('homePage');
Route::get('/admin/product-management', [PageController::class, 'productManagement'])->name('productManagement');
Route::get('/admin/account-management', [PageController::class, 'accountManagement'])->name('accountManagement');
Route::get('/admin/category-management', [PageController::class, 'categoryManagement'])->name('categoryManagement');
Route::get('/admin/ingredient-management', [PageController::class, 'ingredientManagement'])->name('ingredientManagement');
Route::get('/admin/supplier-management', [PageController::class, 'supplierManagement'])->name('supplierManagement');
Route::get('/admin/point-of-sale', [PageController::class, 'pos'])->name('pos');