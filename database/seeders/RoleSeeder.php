<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Administrator',
                'slug' => 'admin',
                'description' => 'Full system access with all privileges'
            ],
            [
                'name' => 'Seller',
                'slug' => 'seller',
                'description' => 'Can manage products and view their own orders'
            ],
            [
                'name' => 'Customer',
                'slug' => 'customer',
                'description' => 'Can browse, purchase products and manage orders'
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
