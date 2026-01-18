<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get sellers
        $sellers = User::whereHas('role', function ($q) {
            $q->where('slug', 'seller');
        })->get();

        // Get categories
        $categories = Category::all();

        $products = [
            // Electronics (Seller 1 - Toqi Ahmed)
            [
                'name' => 'Smartphone X Pro',
                'description' => 'Latest smartphone with 128GB storage, 8GB RAM, and 48MP camera',
                'price' => 34999.00,
                'stock_quantity' => 50,
                'category' => 'Electronics',
                'seller_index' => 0,
                'sku' => 'PHN-XPRO-001',
                'image' => 'products/smartphone.jpg',
            ],
            [
                'name' => 'Wireless Bluetooth Earbuds',
                'description' => 'Noise cancellation wireless earbuds with 30 hours battery',
                'price' => 2499.00,
                'stock_quantity' => 100,
                'category' => 'Electronics',
                'seller_index' => 0,
                'sku' => 'EAR-BT-002',
                'image' => 'products/earbuds.jpg',
            ],
            [
                'name' => 'Laptop Ultrabook',
                'description' => '14-inch laptop with Intel i7, 16GB RAM, 512GB SSD',
                'price' => 89999.00,
                'stock_quantity' => 20,
                'category' => 'Electronics',
                'seller_index' => 0,
                'sku' => 'LAP-ULT-003',
                'image' => 'products/laptop.jpg',
            ],

            // Fashion (Seller 2 - Sayma Jahan)
            [
                'name' => 'Traditional Saree',
                'description' => 'Handwoven cotton saree with elegant design',
                'price' => 3500.00,
                'stock_quantity' => 30,
                'category' => 'Fashion',
                'seller_index' => 1,
                'sku' => 'FSH-SAR-004',
                'image' => 'products/saree.jpg',
            ],
            [
                'name' => 'Men\'s Formal Shirt',
                'description' => 'Premium cotton formal shirt for office wear',
                'price' => 1200.00,
                'stock_quantity' => 75,
                'category' => 'Fashion',
                'seller_index' => 1,
                'sku' => 'FSH-SHT-005',
                'image' => 'products/shirt.jpg',
            ],
            [
                'name' => 'Designer Kurti',
                'description' => 'Embroidered cotton kurti with matching dupatta',
                'price' => 1800.00,
                'stock_quantity' => 40,
                'category' => 'Fashion',
                'seller_index' => 1,
                'sku' => 'FSH-KUR-006',
                'image' => 'products/kurti.jpg',
            ],

            // Furniture (Seller 3 - Prodip Shaha)
            [
                'name' => 'Wooden Dining Table Set',
                'description' => '6-seater wooden dining table with chairs',
                'price' => 25500.00,
                'stock_quantity' => 10,
                'category' => 'Furniture',
                'seller_index' => 2,
                'sku' => 'FUR-DIN-007',
                'image' => 'products/dining-set.jpg',
            ],
            [
                'name' => 'Office Desk Chair',
                'description' => 'Ergonomic office chair with lumbar support',
                'price' => 6500.00,
                'stock_quantity' => 25,
                'category' => 'Furniture',
                'seller_index' => 2,
                'sku' => 'FUR-CHA-008',
                'image' => 'products/chair.jpg',
            ],
            [
                'name' => 'Bookshelf',
                'description' => '5-tier wooden bookshelf with glass doors',
                'price' => 8500.00,
                'stock_quantity' => 15,
                'category' => 'Furniture',
                'seller_index' => 2,
                'sku' => 'FUR-BOK-009',
                'image' => 'products/bookshelf.jpg',
            ],

            // Home & Kitchen (Seller 1)
            [
                'name' => 'Non-Stick Cookware Set',
                'description' => '10-piece non-stick cookware set with utensils',
                'price' => 4500.00,
                'stock_quantity' => 35,
                'category' => 'Home & Kitchen',
                'seller_index' => 0,
                'sku' => 'HOM-COK-010',
                'image' => 'products/cookware.jpg',
            ],

            // Books (Seller 2)
            [
                'name' => 'Bangla Literature Collection',
                'description' => 'Collection of classic Bangla literature books',
                'price' => 1200.00,
                'stock_quantity' => 60,
                'category' => 'Books',
                'seller_index' => 1,
                'sku' => 'BOK-LIT-011',
                'image' => 'products/books.jpg',
            ],

            // Sports (Seller 3)
            [
                'name' => 'Cricket Bat',
                'description' => 'Premium English willow cricket bat',
                'price' => 3500.00,
                'stock_quantity' => 20,
                'category' => 'Sports',
                'seller_index' => 2,
                'sku' => 'SPO-CRI-012',
                'image' => 'products/cricket-bat.jpg',
            ],
        ];

        foreach ($products as $product) {
            $category = $categories->where('name', $product['category'])->first();
            $seller = $sellers[$product['seller_index']];

            Product::create([
                'seller_id' => $seller->id,
                'category_id' => $category->id,
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'sku' => $product['sku'],
                'description' => $product['description'],
                'price' => $product['price'],
                'stock_quantity' => $product['stock_quantity'],
                'approval_status' => 'approved',
                'is_active' => true,
                'image' => $product['image'],
            ]);
        }
    }
}
