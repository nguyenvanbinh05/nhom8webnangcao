<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderManagementContronller;


Route::resource('/orderManagement', OrderManagementContronller::class);

Route::post('/admin/orderManagement/{order}/confirm', [OrderManagementContronller::class, 'confirm'])->name('orderManagement.confirm');