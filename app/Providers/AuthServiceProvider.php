<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Policies\OrderPolicy;
use App\Policies\ProductPolicy;
use App\Policies\OrderItemPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     */
    protected $policies = [
        Order::class => OrderPolicy::class,
        Product::class => ProductPolicy::class,
        OrderItem::class => OrderItemPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // You MUST loop through and register them in Laravel 12
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }

        // Optional: Define a Super Admin bypass
        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });
    }
}
