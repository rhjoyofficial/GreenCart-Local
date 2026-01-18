<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shipment;
use App\Models\Order;
use App\Enums\OrderStatus;

class ShipmentSeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::whereIn('status', [
            OrderStatus::Shipped->value,
            OrderStatus::Delivered->value,
            OrderStatus::Processing->value
        ])->get();

        foreach ($orders as $order) {
            $shipmentStatus = $this->mapOrderToShipmentStatus($order->status);

            $shipment = Shipment::create([
                'order_id' => $order->id,
                'carrier' => $this->getRandomCarrier(),
                'tracking_code' => 'TRK' . strtoupper(uniqid()),
                'status' => $shipmentStatus,
                'created_at' => $order->created_at,
            ]);

            // Add shipped/delivered dates based on status
            if ($shipmentStatus === 'shipped' || $shipmentStatus === 'in_transit') {
                $shipment->update([
                    'shipped_at' => $order->created_at->addDays(1),
                ]);
            }

            if ($shipmentStatus === 'delivered') {
                $shipment->update([
                    'shipped_at' => $order->created_at->addDays(1),
                    'delivered_at' => $order->created_at->addDays(3),
                ]);
            }
        }
    }

    private function mapOrderToShipmentStatus(OrderStatus $orderStatus): string
    {
        $mapping = [
            OrderStatus::Pending->value => 'pending',
            OrderStatus::Processing->value => 'pending',
            OrderStatus::Shipped->value => 'in_transit',
            OrderStatus::Delivered->value => 'delivered',
            OrderStatus::Cancelled->value => 'cancelled',
        ];
        return $mapping[$orderStatus->value] ?? 'pending';
    }

    private function getRandomCarrier(): string
    {
        $carriers = ['Sundarban Couriers', 'SA Paribahan', 'Pathao', 'eCourier', 'Redx'];
        return $carriers[array_rand($carriers)];
    }
}
