<?php

namespace App\Constants;

class PaymentStatus
{
    const PENDING = 'pending';
    const PAID = 'paid';
    const REFUNDED = 'refunded';

    public static function all()
    {
        return [
            self::PENDING,
            self::PAID,
            self::REFUNDED,
        ];
    }
}
