<?php

namespace App\Guards;

use App\Enums\OrderStatus;

class OrderStatusGuard
{
    private static array $transitions = [
        OrderStatus::Pending->value => [OrderStatus::Processing->value, OrderStatus::Cancelled->value],
        OrderStatus::Processing->value => [OrderStatus::Shipped->value, OrderStatus::Cancelled->value],
        OrderStatus::Shipped->value => [OrderStatus::Delivered->value],
        OrderStatus::Delivered->value => [],
        OrderStatus::Cancelled->value => [],
    ];

    public static function canTransition(string $from, string $to): bool
    {
        return in_array($to, self::$transitions[$from] ?? []);
    }

    public static function validate(string $from, string $to): void
    {
        if (!self::canTransition($from, $to)) {
            throw new \DomainException("Invalid order status transition: $from → $to");
        }
    }
}
