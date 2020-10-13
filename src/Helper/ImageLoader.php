<?php

namespace App\Helper;

/**
 * Class ImageLoader
 * @package App\Helper
 */
class ImageLoader
{
    /**
     * @param $imageUrl
     * @return bool|null|string
     */
    public static function getImage($imageUrl): ?string
    {
        try {
            return file_get_contents($imageUrl, false);
        } catch (\Throwable $exception) {
            return null;
        }
    }
}
