<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display wishlist page
     */
    public function index()
    {
        $user = Auth::user();
        $wishlist = $user->defaultWishlist()->with('products.seller')->first();

        $items = $wishlist ? $wishlist->products : collect();

        return view('frontend.wishlist.index', [
            'items' => $items,
            'wishlistCount' => $items->count()
        ]);
    }

    /**
     * Toggle product in wishlist
     */
    public function toggle(Product $product)
    {
        $user = Auth::user();
        $wishlist = $user->defaultWishlist()->firstOrCreate([
            'name' => 'My Wishlist',
            'is_default' => true
        ]);

        $isInWishlist = $wishlist->products()->where('product_id', $product->id)->exists();

        if ($isInWishlist) {
            $wishlist->products()->detach($product->id);
            $message = 'Product removed from wishlist';
            $added = false;
        } else {
            $wishlist->products()->attach($product->id);
            $message = 'Product added to wishlist';
            $added = true;
        }

        $wishlistCount = $wishlist->products()->count();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'added' => $added,
                'wishlist_count' => $wishlistCount
            ]);
        }

        return redirect()->back()
            ->with('success', $message)
            ->with('wishlist_count', $wishlistCount);
    }

    /**
     * Remove product from wishlist
     */
    public function remove(Product $product)
    {
        $user = Auth::user();
        $wishlist = $user->defaultWishlist;

        if ($wishlist) {
            $wishlist->products()->detach($product->id);
        }

        return redirect()->back()
            ->with('success', 'Product removed from wishlist');
    }

    /**
     * Move product from wishlist to cart
     */
    public function moveToCart(Product $product)
    {
        $user = Auth::user();

        // Remove from wishlist
        $wishlist = $user->defaultWishlist;
        if ($wishlist) {
            $wishlist->products()->detach($product->id);
        }

        // Add to cart
        $cart = $user->cart()->firstOrCreate([]);
        $item = $cart->items()->firstOrNew(['product_id' => $product->id]);
        $item->quantity = 1;
        $item->unit_price = $product->price;
        $item->total_price = $product->price;
        $item->save();

        $wishlistCount = $wishlist ? $wishlist->products()->count() : 0;
        $cartCount = $cart->items()->sum('quantity');

        return redirect()->back()
            ->with('success', 'Product moved to cart')
            ->with('wishlist_count', $wishlistCount)
            ->with('cart_count', $cartCount);
    }
}
