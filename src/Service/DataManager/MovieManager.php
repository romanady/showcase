<?php

namespace App\Service\DataManager;

use App\Entity\Image;
use App\Repository\MovieRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Helper\JsonDecoder;
use App\Entity\Movie;

class MovieManager
{
    const CONTENT_TYPE = 'application/json';

    /** @var HttpClientInterface  */
    private $client;

    /** @var EntityManagerInterface  */
    private $entityManager;

    /** @var MovieRepository  */
    private $movieRepository;

    public function __construct(
        HttpClientInterface $client,
        EntityManagerInterface $entityManager,
        MovieRepository $movieRepository
    )
    {
        $this->client = $client;
        $this->entityManager = $entityManager;
        $this->movieRepository = $movieRepository;
    }

    /**
     * Load Json data from data url
     * @return array|mixed|null
     */
    public function loadFromUrl(): array
    {
        try {
            $response = $this->client->request(
                'GET',
                $_ENV['DATA_URL']
            );

            $contentType = $response->getHeaders()['content-type'][0];
            if ($contentType != self::CONTENT_TYPE) {
                return [];
            }
            $content = $response->getContent();
            try {
                // Because $content = $response->toArray(); does not work we need to create a custom logic
                $movies = JsonDecoder::safeJsonDecode($content);
            } catch (\Throwable $exception) {
                $movies = [];
            }

            return $movies;
        } catch (\Throwable $exception) {
            return [];
        }
    }

    /**
     * Store loaded data
     * @throws \Exception
     */
    public function storeData()
    {
        $data = $this->loadFromUrl();
        if (empty($data)) {
            throw new \Exception('Cannot download movie data');
        }

        foreach ($data as $datum) {
            $movie = new Movie();
            foreach ($datum['cardImages'] as $cardImage) {
                $image = new Image();
                $image->setImageUrl($cardImage['url'])
                    ->setWidth($cardImage['w'])
                    ->setHeight($cardImage['h'])
                    ->setType('cardImages');
                $movie->addImage($image);
                $this->entityManager->persist($image);
            }
            $movie->setId($datum['id']);
            $movie->setBody($datum['body']);
            $movie->setCast(json_encode($datum['cast']));
            $movie->setCert($datum['cert']);
            $movie->setClass($datum['class']);
            $movie->setDirectors(json_encode($datum['directors']));
            $movie->setDuration($datum['duration']);
            $movie->setGenres(isset($datum['genres']) ? json_encode($datum['genres']) : '');
            $movie->setHeadline($datum['headline']);

            foreach ($datum['keyArtImages'] as $cardImage) {
                $image = new Image();
                $image->setImageUrl($cardImage['url'])
                    ->setWidth($cardImage['w'])
                    ->setHeight($cardImage['h'])
                    ->setType('keyArtImages');
                $movie->addImage($image);
                $this->entityManager->persist($image);
            }

            $movie->setLastUpdated($datum['lastUpdated']);
            $movie->setQuote(isset($datum['quote']) ? $datum['quote'] : '');
            $movie->setRating(isset($datum['rating']) ? $datum['rating'] : '');
            $movie->setReviewAuthor(isset($datum['reviewAuthor']) ? $datum['reviewAuthor'] : '');
            $movie->setSkyGoId(isset($datum['skyGoId']) ? $datum['skyGoId'] : '');
            $movie->setSkyGoUrl(isset($datum['skyGoUrl']) ? $datum['skyGoUrl'] : '');
            $movie->setSum(isset($datum['sum']) ? $datum['sum'] : '');
            $movie->setSynopsis($datum['synopsis']);
            $movie->setUrl($datum['url']);
            $movie->setVideos(isset($datum['videos']) ? json_encode($datum['videos']) : '');
            $movie->setViewingWindow(isset($datum['viewingWindow']) ? json_encode($datum['viewingWindow']) : '');
            $movie->setYear($datum['year']);

            $this->entityManager->persist($movie);
        }
        $this->entityManager->flush();
    }
}
