<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\Environment;
use App\Service\DataManager\CacheManagerInterface;

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

    public function imageRender($imagesJson, $type)
    {
        $images = json_decode($imagesJson, true);
        $cachedImages = [];
        foreach ($images as $image) {
            $imageUrl = $image['url'];
            $imageContent = $this->imageCacheManager->loadImage($imageUrl);
            if (!$imageContent) {
                continue;
            }
            $cachedImages[] = [
                'content' => $imageContent,
                'height' => $image['h'],
                'width' => $image['w'],
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
