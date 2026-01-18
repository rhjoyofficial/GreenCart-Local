<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        // Sample image URLs (using Unsplash)
        $sampleImages = [
            'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa',
            'https://images.unsplash.com/photo-1542291026-7eec264c27ff',
            'https://images.unsplash.com/photo-1505740420928-5e560c06d30e',
            'https://images.unsplash.com/photo-1523275335684-37898b6baf30',
            'https://images.unsplash.com/photo-1572635196237-14b3f281503f',
            'https://images.unsplash.com/photo-1560343090-f0409e92791a',
            'https://images.unsplash.com/photo-1556656793-08538906a9f8',
            'https://images.unsplash.com/photo-1546868871-7041f2a55e12',
            'https://images.unsplash.com/photo-1546868871-7041f2a55e12',
            'https://images.unsplash.com/photo-1581235720704-06d3acfcb36f',
        ];

        foreach ($products as $index => $product) {
            // Add 2-4 images per product
            $imageCount = rand(2, 4);

            for ($i = 0; $i < $imageCount; $i++) {
                $imageUrl = $sampleImages[array_rand($sampleImages)] . '?w=800&h=600&fit=crop&crop=center&auto=format';

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $imageUrl,
                    'is_primary' => $i === 0, // First image is primary
                ]);
            }
        }
    }
}
