<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Payment;
use App\Services\CartService;
use App\Observers\AuditObserver;
use App\Services\WishlistService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Order::observe(AuditObserver::class);
        Product::observe(AuditObserver::class);
        User::observe(AuditObserver::class);
        Payment::observe(AuditObserver::class);
    }

    public function register()
    {
        $this->app->singleton(CartService::class, function ($app) {
            return new CartService();
        });

        $this->app->singleton(WishlistService::class, function ($app) {
            return new WishlistService();
        });
    }
}
