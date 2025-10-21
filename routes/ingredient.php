<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IngredientController;


Route::resource('/ingredients', IngredientController::class);