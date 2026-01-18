<?php

namespace App\Guards;

class PaymentStatusGuard
{
    private static array $transitions = [
        'pending' => ['success', 'failed'],
        'success' => ['refunded'],
        'failed' => ['pending'], // Allow retry
        'refunded' => [],
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
