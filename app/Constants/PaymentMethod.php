<?php

namespace App\Constants;

class PaymentMethod
{
    const CASH = 'cash';
    const STRIPE = 'stripe';

    public static function getAllMethods()
    {
        return [
            self::CASH,
            self::STRIPE
        ];
    }
}
