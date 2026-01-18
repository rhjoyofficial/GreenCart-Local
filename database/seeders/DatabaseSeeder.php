<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            WishlistSeeder::class,
            OrderSeeder::class,
            PaymentSeeder::class,
            ShipmentSeeder::class,
            AuditLogSeeder::class,
            SalesSummarySeeder::class,
        ]);
    }
}
