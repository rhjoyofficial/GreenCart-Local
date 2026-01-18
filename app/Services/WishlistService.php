<?php

namespace App\Services;

use App\Models\Wishlist;
use App\Models\WishlistItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistService
{
    public function addToWishlist(Product $product, $wishlistName = 'default')
    {
        if (!Auth::check()) {
            return $this->addToSessionWishlist($product);
        }

        $wishlist = Wishlist::firstOrCreate(
            [
                'customer_id' => Auth::id(),
                'is_default' => $wishlistName === 'default'
            ],
            ['name' => $wishlistName]
        );

        WishlistItem::firstOrCreate([
            'wishlist_id' => $wishlist->id,
            'product_id' => $product->id
        ]);

        return $wishlist;
    }

    private function addToSessionWishlist(Product $product)
    {
        $wishlist = session()->get('guest_wishlist', []);

        if (!in_array($product->id, $wishlist)) {
            $wishlist[] = $product->id;
            session()->put('guest_wishlist', $wishlist);
        }

        return $wishlist;
    }

    public function removeFromWishlist($productId, $wishlistId = null)
    {
        if (!Auth::check()) {
            $wishlist = session()->get('guest_wishlist', []);
            $wishlist = array_diff($wishlist, [$productId]);
            session()->put('guest_wishlist', $wishlist);
            return true;
        }

        if ($wishlistId) {
            return WishlistItem::where('wishlist_id', $wishlistId)
                ->where('product_id', $productId)
                ->delete();
        }

        // Remove from all user's wishlists
        $wishlists = Auth::user()->wishlists()->pluck('id');
        return WishlistItem::whereIn('wishlist_id', $wishlists)
            ->where('product_id', $productId)
            ->delete();
    }

    public function getWishlistItems()
    {
        if (!Auth::check()) {
            $productIds = session()->get('guest_wishlist', []);
            return Product::whereIn('id', $productIds)->get();
        }

        return Auth::user()->defaultWishlist?->products ?? collect();
    }

    public function isInWishlist($productId)
    {
        if (!Auth::check()) {
            return in_array($productId, session()->get('guest_wishlist', []));
        }

        return Auth::user()->defaultWishlist?->products()
            ->where('product_id', $productId)
            ->exists();
    }

    public function syncGuestWishlistToUser($user)
    {
        $guestWishlist = session()->get('guest_wishlist', []);

        if ($guestWishlist) {
            $wishlist = Wishlist::firstOrCreate(
                ['customer_id' => $user->id, 'is_default' => true],
                ['name' => 'default']
            );

            foreach ($guestWishlist as $productId) {
                WishlistItem::firstOrCreate([
                    'wishlist_id' => $wishlist->id,
                    'product_id' => $productId
                ]);
            }

            session()->forget('guest_wishlist');
        }
    }
}
