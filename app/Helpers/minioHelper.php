<?php

namespace App\Helpers;

class minioHelper
{
    public static function getMinioUrl($path)
    {
        return config('filesystems.disks.minio.endpoint') . '/' .
            config('filesystems.disks.minio.bucket') . '/' .
            ltrim($path, '/');
    }
}
