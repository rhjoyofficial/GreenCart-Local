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

            // Organic Vegetables (Seller 1 - Toqi Ahmed)
            [
                'name' => 'Deshi Tomato',
                'description' => 'Chemical-free organic tomato grown locally',
                'price' => 90.00,
                'stock_quantity' => 120,
                'category' => 'Organic Vegetables',
                'seller_index' => 0,
                'sku' => 'ORG-VEG-TMT-001',
                'image' => 'products/tomato.jpg',
            ],
            [
                'name' => 'Kacha Morich (Green Chili)',
                'description' => 'Fresh pesticide-free green chili (Kacha Morich)',
                'price' => 120.00,
                'stock_quantity' => 80,
                'category' => 'Organic Vegetables',
                'seller_index' => 0,
                'sku' => 'ORG-VEG-CHL-002',
                'image' => 'products/chili.jpg',
            ],
            [
                'name' => 'Bottle Gourd (Lau)',
                'description' => 'Deshi organic lau from small farmers',
                'price' => 70.00,
                'stock_quantity' => 100,
                'category' => 'Organic Vegetables',
                'seller_index' => 0,
                'sku' => 'ORG-VEG-LAU-003',
                'image' => 'products/lau.jpg',
            ],

            // Organic Fruits (Seller 2 - Sayma Jahan)
            [
                'name' => 'Sagor Kola (Banana)',
                'description' => 'Naturally ripened sagor kola, no carbide',
                'price' => 80.00,
                'stock_quantity' => 150,
                'category' => 'Organic Fruits',
                'seller_index' => 1,
                'sku' => 'ORG-FRT-KLA-004',
                'image' => 'products/banana.jpg',
            ],
            [
                'name' => 'Mango (Himsagar)',
                'description' => 'Chemical-free mango from Chapai Nawabganj',
                'price' => 250.00,
                'stock_quantity' => 200,
                'category' => 'Organic Fruits',
                'seller_index' => 1,
                'sku' => 'ORG-FRT-MNG-005',
                'image' => 'products/mango.jpg',
            ],
            [
                'name' => 'Watermelon (Tormuj)',
                'description' => 'Seasonal organic watermelon',
                'price' => 220.00,
                'stock_quantity' => 60,
                'category' => 'Organic Fruits',
                'seller_index' => 1,
                'sku' => 'ORG-FRT-WTM-006',
                'image' => 'products/watermelon.jpg',
            ],

            // Dairy & Farm Fresh (Seller 3 - Prodip Shaha)
            [
                'name' => 'Pure Cow Milk (1L)',
                'description' => 'Fresh cow milk from local dairy farm',
                'price' => 90.00,
                'stock_quantity' => 70,
                'category' => 'Dairy & Farm Fresh',
                'seller_index' => 2,
                'sku' => 'ORG-DFR-MLK-007',
                'image' => 'products/milk.jpg',
            ],
            [
                'name' => 'Deshi Ghee',
                'description' => 'Pure organic deshi ghee produced from fresh milk',
                'price' => 1200.00,
                'stock_quantity' => 25,
                'category' => 'Dairy & Farm Fresh',
                'seller_index' => 2,
                'sku' => 'ORG-DFR-GHE-008',
                'image' => 'products/ghee.jpg',
            ],
            [
                'name' => 'Free-range Eggs (Dozen)',
                'description' => 'Deshi chicken eggs, free-range and hormone-free',
                'price' => 180.00,
                'stock_quantity' => 90,
                'category' => 'Dairy & Farm Fresh',
                'seller_index' => 2,
                'sku' => 'ORG-DFR-EGG-009',
                'image' => 'products/eggs.jpg',
            ],

            // Honey & Jaggery (Seller 1)
            [
                'name' => 'Sundarbans Natural Honey',
                'description' => 'Raw forest honey directly from Sundarbans',
                'price' => 650.00,
                'stock_quantity' => 40,
                'category' => 'Honey & Jaggery',
                'seller_index' => 0,
                'sku' => 'ORG-HNJ-HNY-010',
                'image' => 'products/honey.jpg',
            ],
            [
                'name' => 'Khejur Gur (Patali)',
                'description' => 'Traditional date palm jaggery (patali gur)',
                'price' => 300.00,
                'stock_quantity' => 55,
                'category' => 'Honey & Jaggery',
                'seller_index' => 0,
                'sku' => 'ORG-HNJ-GUR-011',
                'image' => 'products/gur.jpg',
            ],

            // Rice, Pulses & Grains (Seller 2)
            [
                'name' => 'Chinigura Rice (1kg)',
                'description' => 'Premium aromatic chinigura rice (organic)',
                'price' => 150.00,
                'stock_quantity' => 200,
                'category' => 'Rice, Pulses & Grains',
                'seller_index' => 1,
                'sku' => 'ORG-RPG-RCU-012',
                'image' => 'products/chinigura.jpg',
            ],
            [
                'name' => 'Masoor Dal (1kg)',
                'description' => 'Chemical-free red lentil (masoor dal)',
                'price' => 130.00,
                'stock_quantity' => 170,
                'category' => 'Rice, Pulses & Grains',
                'seller_index' => 1,
                'sku' => 'ORG-RPG-MSD-013',
                'image' => 'products/masoor.jpg',
            ],

            // Snacks & Homemade (Seller 3)
            [
                'name' => 'Mixed Achar (Pickle)',
                'description' => 'Handmade achar with mustard oil',
                'price' => 220.00,
                'stock_quantity' => 60,
                'category' => 'Snacks & Homemade',
                'seller_index' => 2,
                'sku' => 'ORG-SNK-ACH-014',
                'image' => 'products/achar.jpg',
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
