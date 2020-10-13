<?php

namespace App\Twig;

use App\Entity\Image;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\Environment;
use App\Service\DataManager\CacheManagerInterface;
use Doctrine\ORM\PersistentCollection;

class AppExtension extends AbstractExtension
{
    /** @var CacheManagerInterface */
    private $imageCacheManager;

    /** @var Environment */
    private $twig;

    public function __construct(CacheManagerInterface $imageCacheManager, Environment $twig)
    {
        $this->imageCacheManager = $imageCacheManager;
        $this->twig = $twig;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('imageRender', [$this, 'imageRender']),
        ];
    }

    /**
     * @param $images
     * @param $type
     * @return mixed
     */
    public function imageRender(PersistentCollection $images, string $type)
    {
        $cachedImages = [];
        /** @var Image $image */
        foreach ($images as $image) {
            if ($image->getType() != $type) {
                continue;
            }
            if (!$imageContent = $this->imageCacheManager->loadImage($image->getId(), $image->getImageUrl())) {
                // Image was not found
                continue;
            }
            $cachedImages[] = [
                'content' => $imageContent,
                'height' => $image->getHeight(),
                'width' => $image->getWidth(),
            ];
        }
        return $this->twig->render(
            'partials/image/imageRenderer.html.twig',
            [
                'images' => $cachedImages
            ]
        );
    }
}
