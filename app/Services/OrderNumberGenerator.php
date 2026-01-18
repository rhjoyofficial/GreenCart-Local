<?php

namespace App\Services;

class OrderNumberGenerator
{
    public static function generate(): string
    {
        return 'ORD-' . now()->format('Ymd') . '-' . random_int(100000, 999999);
    }
}
