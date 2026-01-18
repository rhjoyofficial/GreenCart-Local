<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use App\Enums\OrderStatus;
use App\Services\OrderNumberGenerator;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Get customers and products
        $customers = User::whereHas('role', function ($q) {
            $q->where('slug', 'customer');
        })->get();

        $products = Product::all();

        $orders = [];

        // Create orders for each customer
        foreach ($customers as $customer) {
            for ($i = 1; $i <= 2; $i++) {
                $order = Order::create([
                    'customer_id' => $customer->id,
                    'order_number' => OrderNumberGenerator::generate(),
                    'total_amount' => 0, // Will be calculated
                    'status' => $this->getRandomStatus(),
                    'shipping_address' => $customer->address_line1 . ', ' . $customer->city . ', ' . $customer->country,
                    'billing_address' => $customer->address_line1 . ', ' . $customer->city . ', ' . $customer->country,
                    'payment_method' => $this->getRandomPaymentMethod(),
                    'payment_status' => $this->getRandomPaymentStatus(),
                    'notes' => $i === 1 ? 'Please deliver before 5 PM' : null,
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);

                // Add 2-4 items to each order
                $orderItems = [];
                $selectedProducts = $products->random(rand(2, 4));
                $totalAmount = 0;

                foreach ($selectedProducts as $product) {
                    $quantity = rand(1, 3);
                    $unitPrice = $product->price;
                    $itemTotal = $quantity * $unitPrice;
                    $totalAmount += $itemTotal;

                    $orderItems[] = [
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'seller_id' => $product->seller_id,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'total_price' => $itemTotal,
                        'created_at' => $order->created_at,
                        'updated_at' => $order->created_at,
                    ];
                }

                // Insert order items
                OrderItem::insert($orderItems);

                // Update order total amount
                $order->update(['total_amount' => $totalAmount]);

                $orders[] = $order;
            }
        }
    }

    private function getRandomStatus(): string
    {
        $statuses = [
            OrderStatus::Pending->value,
            OrderStatus::Processing->value,
            OrderStatus::Shipped->value,
            OrderStatus::Delivered->value,
            OrderStatus::Cancelled->value,
        ];
        return $statuses[array_rand($statuses)];
    }

    private function getRandomPaymentMethod(): string
    {
        $methods = ['Cash on Delivery', 'Credit Card', 'bKash', 'Nagad', 'Bank Transfer'];
        return $methods[array_rand($methods)];
    }

    private function getRandomPaymentStatus(): string
    {
        $statuses = ['pending', 'paid', 'failed'];
        return $statuses[array_rand($statuses)];
    }
}
