<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'role_id' => 3, // Default to customer
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'phone' => fake()->phoneNumber(),
            'address_line1' => fake()->streetAddress(),
            'address_line2' => fake()->secondaryAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'postal_code' => fake()->postcode(),
            'country' => fake()->country(),
            'is_active' => fake()->boolean(90),
            'remember_token' => \Illuminate\Support\Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    // Add state methods for different roles
    public function admin(): static
    {
        return $this->state(fn(array $attributes) => [
            'role_id' => 1,
            'name' => 'Admin ' . fake()->name(),
        ]);
    }

    public function seller(): static
    {
        return $this->state(fn(array $attributes) => [
            'role_id' => 2,
            'name' => fake()->company() . ' Seller',
        ]);
    }

    public function customer(): static
    {
        return $this->state(fn(array $attributes) => [
            'role_id' => 3,
        ]);
    }
}
