<?php

namespace App\Service\DataManager;

use App\Entity\Image;
use App\Helper\ImageLoader;
use Symfony\Component\Cache\Adapter\MemcachedAdapter;
use Doctrine\ORM\EntityManagerInterface;

class MemcacheManager implements CacheManagerInterface
{
    /** @var \Memcached */
    private $client;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

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
                $this->deleteImage($imageId);
                /**
                 * If image is not found delete it so it does not affect page load in the future
                 * A cronjob can be set to check for new images
                 */
                return null;
            }
            $cachedImage = base64_encode($imageContent);
            $this->client->set($imageId, $cachedImage, '86400');
        }

        return $cachedImage;
    }

    /**
     * @param $imageId
     */
    protected function deleteImage($id)
    {
        $image = $this->entityManager->getRepository(Image::class)->find($id);
        if (!$image) {
            throw $this->createNotFoundException(
                'No image found for id ' . $id
            );
        }
        $this->entityManager->remove($image);
        $this->entityManager->flush();
    }
}
