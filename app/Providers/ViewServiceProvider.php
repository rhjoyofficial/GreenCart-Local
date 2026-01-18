<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Global Categories
        View::composer('*', function ($view) {
            $categories = Category::withCount('products')
                ->whereHas('products')
                ->get();

            $view->with('navCategories', $categories);
        });

        // Global Cart Count
        View::composer('*', function ($view) {
            $cartCount = 0;

            if (Auth::check() && Auth::user()->hasRole('customer')) {
                // For logged-in customers
                $cart = Auth::user()->cart;
                if ($cart) {
                    $cartCount = $cart->items()->sum('quantity');
                }
            } else {
                // For guests
                $guestCart = session()->get('guest_cart', ['items' => [], 'total_price' => 0]);
                if (isset($guestCart['items']) && is_array($guestCart['items'])) {
                    foreach ($guestCart['items'] as $item) {
                        $cartCount += $item['quantity'] ?? 0;
                    }
                }
            }

            $view->with('cartCount', $cartCount);
        });
    }
}
