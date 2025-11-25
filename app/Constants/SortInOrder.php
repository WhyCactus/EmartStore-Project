<?php

namespace App\Constants;

class SortInOrder
{
    const ASC = 'asc';
    const DESC = 'desc';

    public static function getAllowableEnumValues(): array
    {
        return [
            self::ASC,
            self::DESC,
        ];
    }
}
