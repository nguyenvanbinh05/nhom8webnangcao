<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminProductController;


Route::resource('/product', AdminProductController::class);