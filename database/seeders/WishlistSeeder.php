<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use App\Models\User;
use App\Models\Product;

class WishlistSeeder extends Seeder
{
    public function run(): void
    {
        // Get customers
        $customers = User::whereHas('role', function ($q) {
            $q->where('slug', 'customer');
        })->take(3)->get();

        // Get some products
        $products = Product::take(6)->get();

        foreach ($customers as $index => $customer) {
            // Create default wishlist for each customer
            $wishlist = Wishlist::create([
                'customer_id' => $customer->id,
                'name' => 'My Wishlist',
                'is_default' => true,
            ]);

            // Add 2-3 products to each wishlist
            $productsToAdd = $products->slice($index * 2, 2);

            foreach ($productsToAdd as $product) {
                WishlistItem::create([
                    'wishlist_id' => $wishlist->id,
                    'product_id' => $product->id,
                ]);
            }
        }
    }
}
