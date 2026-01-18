<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuditLog;
use App\Models\User;

class AuditLogSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $actions = ['login', 'logout', 'profile_update', 'order_created', 'product_added', 'user_created'];

        for ($i = 0; $i < 50; $i++) {
            AuditLog::create([
                'user_id' => $users->random()->id,
                'action' => $actions[array_rand($actions)],
                'details' => json_encode([
                    'ip_address' => '192.168.' . rand(1, 255) . '.' . rand(1, 255),
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'timestamp' => now()->subDays(rand(0, 60))->toDateTimeString(),
                ]),
                'model_type' => 'App\\Models\\' . ucfirst($actions[array_rand(['User', 'Order', 'Product'])]),
                'model_id' => rand(1, 20),
                'created_at' => now()->subDays(rand(0, 60)),
            ]);
        }
    }
}
