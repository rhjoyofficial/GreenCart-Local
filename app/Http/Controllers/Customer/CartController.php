<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('frontend.cart.index');
    }

    public function add(Product $product, Request $request, CartService $cart)
    {
        $request->validate(['quantity' => 'integer|min:1']);

        $cart->add($product, $request->quantity ?? 1);

        return response()->json([
            'success' => true,
            'cart_count' => $cart->count(),
            'cart_total' => $cart->totalFormatted(),
        ]);
    }

    public function remove($itemId, CartService $cart)
    {
        $cart->remove($itemId);

        return response()->json([
            'success' => true,
            'cart_count' => $cart->count(),
        ]);
    }
}
