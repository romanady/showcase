<?php

namespace App\Service\DataManager;

use App\Helper\ImageLoader;
use Symfony\Component\Cache\Adapter\MemcachedAdapter;

class MemcacheManager implements CacheManagerInterface
{
    /** @var \Memcached */
    private $client;

    public function __construct()
    {
        try {
            $this->client = MemcachedAdapter::createConnection(
                $_ENV['MEMCAHE_DATA']
            );

            return $this->client;
        } catch (\Throwable $exception) {
            // Could not make a memcache connection
            return null;
        }
    }

    /**
     * @param string $imageId
     * @param string $imageUrl
     * @return bool|string
     */
    public function loadImage(string $imageId, string $imageUrl): ?string
    {
        // If we cannot make a Memcache connection, just return the received value
        if (!$this->client) {
            return base64_encode($imageUrl);
        }

        $cachedImage = $this->client->get($imageId);

        if ($this->client->getResultMessage() != 'SUCCESS') { // todo use constant
            if (!$imageContent = ImageLoader::getImage($imageUrl)) {
                // If image is not found, ignore the entry
                return null;
            }
            $cachedImage = base64_encode($imageContent);
            $this->client->set($imageId, $cachedImage, '86400');
        }

        return $cachedImage;
    }
}
