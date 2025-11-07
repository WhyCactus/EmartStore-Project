<?php

namespace App\Constants;

class CommonStatus
{
    const ACTIVE = 'active';
    const INACTIVE = 'inactive';

    public static function all()
    {
        return [
            self::ACTIVE => __('active'),
            self::INACTIVE => __('inactive'),
        ];
    }

    public static function getLabel($status): string
    {
        return self::all()[$status] ?? 'Unknown';
    }

    public static function isValid($status): bool
    {
        return in_array($status, [self::ACTIVE, self::INACTIVE]);
    }
}
