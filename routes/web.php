<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\IngredientController;


Route::get('/', function () {

    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect('/admin');
        } elseif ($user->role === 'staff') {
            return redirect('/admin');
        } else {
            return view('costumer.home');
        }
    }

    return view('costumer.home');
})->name('home');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/costumer.php';

Route::prefix('admin')->group(function () {

    Route::middleware(['auth', 'role:admin,staff'])->group(function () {
        Route::get('/', [PageController::class, 'homePage'])->name('homePage');
        Route::get('/product-management', [PageController::class, 'productManagement'])->name('productManagement');
        Route::get('/point-of-sale', [PageController::class, 'pos'])->name('pos');
        Route::get('/product-management/add', [PageController::class, 'productAdd'])->name('productAdd');
    });

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/account-management', [PageController::class, 'accountManagement'])->name('accountManagement');
        Route::get('/category-management', [PageController::class, 'categoryManagement'])->name('categoryManagement');
        Route::resource('/supplier', SupplierController::class);
        Route::resource('/ingredients', IngredientController::class);
    });
});
