<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Category;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'seller_id' => User::factory()->seller(),
            'category_id' => Category::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->paragraphs(2, true),
            'price' => fake()->randomFloat(2, 10, 1000),
            'stock_quantity' => fake()->numberBetween(0, 200),
            'is_active' => fake()->boolean(90),
        ];
    }

    public function forSeller($sellerId): static
    {
        return $this->state(fn(array $attributes) => [
            'seller_id' => $sellerId,
        ]);
    }

    public function forCategory($categoryId): static
    {
        return $this->state(fn(array $attributes) => [
            'category_id' => $categoryId,
        ]);
    }
}
