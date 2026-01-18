<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Organic Vegetables',
                'description' => 'Locally grown seasonal organic vegetables',
            ],
            [
                'name' => 'Organic Fruits',
                'description' => 'Chemical-free fresh fruits sourced from local farms',
            ],
            [
                'name' => 'Dairy & Farm Fresh',
                'description' => 'Fresh milk, yogurt, ghee, butter, and eggs from organic farms',
            ],
            [
                'name' => 'Rice, Pulses & Grains',
                'description' => 'Organic rice, lentils, wheat, and grains sourced directly from farmers',
            ],
            [
                'name' => 'Oil & Spices',
                'description' => 'Cold-pressed oils, natural spices, and herbs',
            ],
            [
                'name' => 'Honey & Jaggery',
                'description' => 'Raw honey, date molasses, palm jaggery, and local sweeteners',
            ],
            [
                'name' => 'Fish & Meat',
                'description' => 'Organic chickens, free-range meats, and farmed fish',
            ],
            [
                'name' => 'Herbal & Wellness',
                'description' => 'Natural herbs, remedies, wellness goods, and ayurvedic items',
            ],
            [
                'name' => 'Snacks & Homemade',
                'description' => 'Homemade pickles, dry snacks, and healthy food items',
            ],
            [
                'name' => 'Seeds & Gardening',
                'description' => 'Organic seeds, compost, fertilizer, and gardening supplies',
            ],
        ];


        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }
}
