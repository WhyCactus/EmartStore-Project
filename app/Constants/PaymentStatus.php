<?php

namespace App\Constants;

class PaymentStatus
{
    const PENDING = 'pending';
    const PAID = 'paid';
    const REFUNDED = 'refunded';
    const CANCELLED = 'cancelled';

    public static function getAllStatus()
    {
        return [
            self::PENDING,
            self::PAID,
            self::REFUNDED,
            self::CANCELLED
        ];
    }
}
