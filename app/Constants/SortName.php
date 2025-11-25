<?php

namespace App\Constants;

class SortName
{
    const SORT_NEWEST = "newest";
    const SORT_POPULAR = "popular";

    public static function getAllowableEnumValues()
    {
        return [
            self::SORT_NEWEST,
            self::SORT_POPULAR,
        ];
    }
}
