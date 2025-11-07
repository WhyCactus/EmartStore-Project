<?php

namespace App\Constants;

class UserRole
{
    const ADMIN = 1;
    const USER = 2;

    public static function all()
    {
        return [
            self::ADMIN,
            self::USER,
        ];
    }
}
