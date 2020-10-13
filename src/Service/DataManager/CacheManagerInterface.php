<?php
namespace App\Service\DataManager;

interface CacheManagerInterface
{
    public function loadImage(string $imageId, string $imageUrl);
}
