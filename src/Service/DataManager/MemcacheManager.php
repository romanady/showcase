<?php

namespace App\Service\DataManager;

use Symfony\Component\Cache\Adapter\MemcachedAdapter;

// todo -> static ImageHelper
class MemcacheManager implements CacheManagerInterface
{

    /** @var \Memcached */
    private $client;

    public function __construct()
    {
        try {
            $this->client = MemcachedAdapter::createConnection(
                'memcached://localhost:11211' // todo use .env parameters
            );

            return $this->client;
        } catch (\Throwable $exception) {
            return null;
        }
    }

    /**
     * @param string $imageId
     * @param string $imageUrl
     * @return bool|string
     */
    public function loadImage(string $imageId, string $imageUrl)
    {
        // If we cannot make a Memcache connection, just return the received value
        if (!$this->client) {
            return base64_encode($imageUrl);
        }

        if (!$cachedImage = $this->client->get($imageId)) {
            try {
                $imageContent = file_get_contents($imageUrl, false);
            } catch (\Throwable $exception) {
                // If image is not found, ignore the entry
                return null;
            }
            $cachedImage = base64_encode($imageContent);
            $this->client->set($imageId, $cachedImage, '86400');
        }

        return $cachedImage;
    }
}
