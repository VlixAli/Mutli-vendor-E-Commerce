<?php

use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::controller(ProductsController::class)->name('products.')->group(function (){
    Route::get('/products', 'index')->name('index');
    Route::get('/products/{product:slug}', 'show')->name('show');
});

Route::resource('cart', CartController::class);

Route::controller(CheckoutController::class)->name('checkout')->group(function (){
    Route::get('checkout' , 'create');
    Route::post('checkout' , 'store');
});

//require __DIR__ . '/auth.php';
require __DIR__ . '/dashboard.php';


