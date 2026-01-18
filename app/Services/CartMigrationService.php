<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartMigrationService
{
    public function migrate(): void
    {
        if (!session()->has('cart')) return;

        $user = Auth::user();
        $cart = $user->cart()->firstOrCreate([]);

        foreach (session('cart') as $productId => $item) {
            $cart->items()->updateOrCreate(
                ['product_id' => $productId],
                [
                    'quantity' => DB::raw('quantity + ' . $item['quantity']),
                    'unit_price' => $item['price'],
                    'total_price' => $item['price'] * $item['quantity'],
                ]
            );
        }

        session()->forget('cart');
    }
}
