<?php

namespace App\Providers;

use App\Repositories\Cart\CartRepository;
use App\Repositories\Cart\CartRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CartRepository::class , fn()=> new CartRepositoryImpl());
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
