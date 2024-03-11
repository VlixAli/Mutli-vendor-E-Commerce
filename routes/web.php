<?php

use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Front\Auth\TwoFactorAuthenticationController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\CurrencyConverterController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PaymentsController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
], function () {
    Route::get('/', [HomeController::class, 'index'])
        ->name('home');

    Route::controller(ProductsController::class)->name('products.')->group(function () {
        Route::get('/products', 'index')->name('index');
        Route::get('/products/{product:slug}', 'show')->name('show');
    });

    Route::resource('cart', CartController::class);

    Route::controller(CheckoutController::class)->name('checkout')->group(function () {
        Route::get('checkout', 'create');
        Route::post('checkout', 'store');
    });

    Route::get('auth/user/2fa', [TwoFactorAuthenticationController::class, 'index'])
        ->name('front.2fa');

    Route::post('currency', [CurrencyConverterController::class, 'store'])
        ->name('currency.store');

    Route::prefix('auth/{provider}')->group(function () {
        Route::controller(SocialLoginController::class)
            ->as('auth.socialite.')
            ->group(function () {
                Route::get('/redirect', 'redirect')->name('redirect');
                Route::get('/callback', 'callback')->name('callback');
            });
        Route::get('/user', [SocialController::class, 'index']);
    });


    Route::controller(PaymentsController::class)
        ->prefix('orders/{order}')->group(function () {
            Route::get('/pay', 'create')
                ->name('orders.payments.create');

            Route::post('/stripe/payment-intent', 'createStripePaymentIntent')
                ->name('stripe.paymentIntent.create');

            Route::get('/pay/stripe/callback', 'confirm')
                ->name('stripe.return');
        });
});


//require __DIR__ . '/auth.php';
require __DIR__ . '/dashboard.php';


