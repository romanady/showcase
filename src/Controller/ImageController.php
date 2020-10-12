<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use App\Service\DataManager\CacheManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    /**
     * This controller could be used to load images via Ajax todo -> remove this Controller
     * @Route("/image/{id}/{type}", name="image_show", methods={"GET"})
     */
    public function imageShow($id, $type, MovieRepository $movieRepository, CacheManagerInterface $imageCacheManager)
    {
        $movie = $movieRepository->find($id);
        $getter = 'get' . ucfirst($type);
        $images = json_decode($movie->$getter(), true);
        $imageContents = [];
        foreach ($images as $image) {
            // check if image is cached
            $imageUrl = $image['url'];
            $imageContents[] = $imageCacheManager->loadImage($imageUrl, $this->loadImageContentFromUrl($imageUrl));
        }

        return $this->render('image/images.html.twig', [
            'images' => $imageContents
        ]);
    }

    private function loadImageContentFromUrl($imageUrl)
    {
        try {
            // todo check xml not found
            $imageContent = file_get_contents($imageUrl, false);
            return $imageContent;
        } catch (\Exception $exception) {
            return null;
        }
    }
}
