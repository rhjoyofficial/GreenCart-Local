<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalesSummaryDaily;
use Carbon\Carbon;

class SalesSummarySeeder extends Seeder
{
    public function run(): void
    {
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            // Simulate some days with no sales
            if (rand(0, 10) > 2) {
                SalesSummaryDaily::create([
                    'date' => $date->format('Y-m-d'),
                    'total_orders' => rand(5, 50),
                    'total_amount' => rand(5000, 500000) / 100 * 100, // Round to nearest 100
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
        }
    }
}
