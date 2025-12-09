<?php

if (!function_exists('minioUrl')) {
    function minioUrl($path)
    {
        return \App\Helpers\minioHelper::getMinioUrl($path);
    }
}
