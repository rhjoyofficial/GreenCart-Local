<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function add(Product $product, int $quantity): void
    {
        if (!Auth::check()) {
            $this->addToSession($product, $quantity);
            return;
        }

        $cart = Auth::user()->cart()->firstOrCreate([]);

        $item = $cart->items()->firstOrNew(['product_id' => $product->id]);
        $item->quantity += $quantity;
        $item->unit_price = $product->price;
        $item->total_price = $item->quantity * $item->unit_price;
        $item->save();
    }

    protected function addToSession(Product $product, int $quantity): void
    {
        $cart = Session::get('cart', []);
        $cart[$product->id]['quantity'] = ($cart[$product->id]['quantity'] ?? 0) + $quantity;
        $cart[$product->id]['price'] = $product->price;
        Session::put('cart', $cart);
    }

    public function count(): int
    {
        if (!Auth::check()) {
            return collect(Session::get('cart'))->sum('quantity');
        }

        return Auth::user()->cart?->items()->sum('quantity') ?? 0;
    }

    public function totalFormatted(): string
    {
        $total = Auth::check()
            ? Auth::user()->cart?->items()->sum('total_price')
            : collect(Session::get('cart'))->sum(fn($i) => $i['price'] * $i['quantity']);

        return 'TK ' . number_format($total ?? 0, 2);
    }

    public function remove(int $itemId): void
    {
        if (Auth::check()) {
            CartItem::where('id', $itemId)->delete();
        } else {
            $cart = Session::get('cart', []);
            unset($cart[$itemId]);
            Session::put('cart', $cart);
        }
    }
}
