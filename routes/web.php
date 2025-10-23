<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Auth\MustVerifyEmail;



Route::get('/', function () {

    if (Auth::check()) {
        $user = Auth::user();
        if (in_array($user->role, ['admin', 'staff'], true)) {
            return redirect('/admin');
        }
        if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice'); // trang nhắc xác minh của Breeze
        }
    }

    return view('customer.home');
})->name('home');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/customer.php';


Route::prefix('admin')->group(function () {

    Route::middleware(['auth', 'verified', 'role:admin,staff'])->group(function () {
        Route::get('/', [PageController::class, 'homePage'])->name('homePage');
        require __DIR__ . '/orderManagement.php';
        Route::get('/point-of-sale', [PageController::class, 'pos'])->name('pos');
    });

    Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
        route::resource('/accounts', AccountController::class);
        require __DIR__ . '/supplier.php';
        require __DIR__ . '/ingredient.php';
        require __DIR__ . '/adminProduct.php';
        require __DIR__ . '/category.php';
    });
});
