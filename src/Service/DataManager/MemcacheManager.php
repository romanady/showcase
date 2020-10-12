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
    public function loadImage($imageUrl)
    {
        // If we cannot make a Memcache connection, just return the received value
        if (!$this->client) {
            return $imageUrl;
        }

        $key = md5($imageUrl);

        if (!$cachedImage = $this->client->get($key)) {
            $imageContent = $this->loadImageContentFromUrl($imageUrl);
            if (!$imageContent) {
                // If image is not found, ignore the entry
                return null;
            }
            $cachedImage = base64_encode($imageContent);
            $this->client->set($key, $cachedImage, '86400');
        }

        return $cachedImage;
    }

    /**
     * @param $imageUrl
     * @return bool|null|string
     */
    private function loadImageContentFromUrl($imageUrl)
    {
        // todo move this
        try {
            $imageContent = file_get_contents($imageUrl, false);
            return $imageContent;
        } catch (\Exception $exception) {
            // Image not found
            return null;
        }
    }
}
