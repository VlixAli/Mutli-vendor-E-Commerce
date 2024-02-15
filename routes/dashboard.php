<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use Illuminate\Support\Facades\Route;

Route::resource('/dashboard/categories' , CategoriesController::class);
