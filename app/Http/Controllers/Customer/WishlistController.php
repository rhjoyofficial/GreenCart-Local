<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        return view('frontend.wishlist.index', [
            'items' => Auth::user()->defaultWishlist->products,
        ]);
    }

    public function toggle(Product $product)
    {
        $wishlist = Auth::user()->defaultWishlist()->firstOrCreate([]);

        $wishlist->products()->toggle($product->id);

        return response()->json([
            'success' => true,
            'wishlist_count' => $wishlist->products()->count(),
        ]);
    }
}
