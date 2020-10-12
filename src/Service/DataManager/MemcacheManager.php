<?php

namespace App\Service\DataManager;

use Symfony\Component\Cache\Adapter\MemcachedAdapter;

class MemcacheManager implements CacheManagerInterface
{

    /** @var \Memcached */
    private $client;

    public function __construct()
    {
        try {
            $this->client = MemcachedAdapter::createConnection(
                'memcached:?host[localhost]&host[localhost:"11211"]&host[/some/memcached.sock:]=3'
            );

            $this->client = MemcachedAdapter::createConnection(
                'memcached://localhost:11211'
            );

            return $this->client;
        } catch (\Exception $exception) {
            return null;
        }

    }

    /**
     * @param $imageUrl
     * @param $imageContent
     * @return bool|string
     */
    public function loadImage($imageUrl, $imageContent)
    {
        // If we cannot make a Memcache connection, just return the received value
        if (!$this->client) {
            return $imageContent;
        }

        if (!$cachedImage = $this->client->get($imageUrl)) {
            $cachedImage = base64_encode($imageContent);
            $this->client->set($imageUrl, $cachedImage);
        }

        return base64_decode($cachedImage);
    }
}
