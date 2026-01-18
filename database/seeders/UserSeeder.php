<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Get roles
        $adminRole = Role::where('slug', 'admin')->first();
        $sellerRole = Role::where('slug', 'seller')->first();
        $customerRole = Role::where('slug', 'customer')->first();

        // Admin User
        User::create([
            'name' => 'Rakibul Hasan Joy',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'phone' => '+8801712345678',
            'address_line1' => '123 Admin Street',
            'city' => 'Dhaka',
            'state' => 'Dhaka Division',
            'postal_code' => '1207',
            'country' => 'Bangladesh',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Seller Users
        $sellers = [
            [
                'name' => 'Toqi Ahmed',
                'email' => 'seller@example.com',
                'password' => Hash::make('password'),
                'business_name' => 'Toqi Electronics',
                'phone' => '+8801812345678',
                'address_line1' => '456 Seller Road',
                'city' => 'Chittagong',
                'state' => 'Chittagong Division',
                'postal_code' => '4000',
                'country' => 'Bangladesh',
                'is_active' => true,
            ],
            [
                'name' => 'Sayma Jahan',
                'email' => 'seller2@example.com',
                'password' => Hash::make('password'),
                'business_name' => 'Sayma Fashion House',
                'phone' => '+8801912345678',
                'address_line1' => '789 Fashion Street',
                'city' => 'Dhaka',
                'state' => 'Dhaka Division',
                'postal_code' => '1209',
                'country' => 'Bangladesh',
                'is_active' => true,
            ],
            [
                'name' => 'Prodip Shaha',
                'email' => 'seller3@example.com',
                'password' => Hash::make('password'),
                'business_name' => 'Shaha Furniture Mart',
                'phone' => '+8801512345678',
                'address_line1' => '321 Furniture Lane',
                'city' => 'Rajshahi',
                'state' => 'Rajshahi Division',
                'postal_code' => '6000',
                'country' => 'Bangladesh',
                'is_active' => true,
            ],
        ];

        foreach ($sellers as $seller) {
            User::create(array_merge($seller, [
                'role_id' => $sellerRole->id,
                'email_verified_at' => now(),
            ]));
        }

        // Customer Users
        $customers = [
            [
                'name' => 'Nasir Uddin',
                'email' => 'customer@example.com',
                'password' => Hash::make('password'),
                'phone' => '+8801612345678',
                'address_line1' => '101 Customer Avenue',
                'city' => 'Sylhet',
                'state' => 'Sylhet Division',
                'postal_code' => '3100',
                'country' => 'Bangladesh',
                'is_active' => true,
            ],
            [
                'name' => 'Ayesha Rahman',
                'email' => 'customer2@example.com',
                'password' => Hash::make('password'),
                'phone' => '+8801312345678',
                'address_line1' => '202 Green Road',
                'city' => 'Dhaka',
                'state' => 'Dhaka Division',
                'postal_code' => '1205',
                'country' => 'Bangladesh',
                'is_active' => true,
            ],
            [
                'name' => 'Kamal Hossain',
                'email' => 'customer3@example.com',
                'password' => Hash::make('password'),
                'phone' => '+8801412345678',
                'address_line1' => '303 Lake View',
                'city' => 'Khulna',
                'state' => 'Khulna Division',
                'postal_code' => '9000',
                'country' => 'Bangladesh',
                'is_active' => true,
            ],
            [
                'name' => 'Fatima Begum',
                'email' => 'customer4@example.com',
                'password' => Hash::make('password'),
                'phone' => '+8801212345678',
                'address_line1' => '404 Rose Lane',
                'city' => 'Barishal',
                'state' => 'Barishal Division',
                'postal_code' => '8200',
                'country' => 'Bangladesh',
                'is_active' => true,
            ],
            [
                'name' => 'Abdul Karim',
                'email' => 'customer5@example.com',
                'password' => Hash::make('password'),
                'phone' => '+8801112345678',
                'address_line1' => '505 Palm Street',
                'city' => 'Rangpur',
                'state' => 'Rangpur Division',
                'postal_code' => '5400',
                'country' => 'Bangladesh',
                'is_active' => true,
            ],
        ];

        foreach ($customers as $customer) {
            User::create(array_merge($customer, [
                'role_id' => $customerRole->id,
                'email_verified_at' => now(),
            ]));
        }
    }
}
