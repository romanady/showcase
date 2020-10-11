<?php

namespace App\Service\DataManager;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Helper\JsonDecoder;
use App\Entity\Movie;
use App\Service\DataManager\DataValidatorTrait;

class MovieManager implements DataManagerInterface
{
    const MOVIE_JSON_URL = 'https://mgtechtest.blob.core.windows.net/files/showcase.json';
    const CONTENT_TYPE = 'application/json';

    /** @var HttpClientInterface  */
    private $client;

    /** @var EntityManagerInterface  */
    private $entityManager;

    /** @var JsonDecoder  */
    private $jsonDecoder;

    public function __construct(
        HttpClientInterface $client,
        EntityManagerInterface $entityManager,
        JsonDecoder $jsonDecoder
    )
    {
        $this->client = $client;
        $this->entityManager = $entityManager;
        $this->jsonDecoder = $jsonDecoder;
    }

    /**
     * @return array|mixed|null
     */
    public function loadFromUrl()
    {
        try {
            $response = $this->client->request(
                'GET',
                self::MOVIE_JSON_URL
            );

            $contentType = $response->getHeaders()['content-type'][0];
            if ($contentType != self::CONTENT_TYPE) {
                return [];
            }
            $content = $response->getContent();
            try {
                // Because $content = $response->toArray(); does not work we will
                $movies = $this->jsonDecoder->safeJsonDecode($content);
            } catch (\Exception $exception) {
                $movies = [];
            }

            return $movies;
        } catch (\Exception $exception) {
            return [];
        }
    }

    /**
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
//            $columns = array_keys($datum);
//            foreach ($columns as $column) {
//                var_dump('set' . ucfirst($column) . '()');
//            }
            $movie->setId($datum['id']);
            $movie->setBody($datum['body']);
            $movie->setCardImages(json_encode($datum['cardImages']));
            $movie->setCast(json_encode($datum['cast']));
            $movie->setCert($datum['cert']);
            $movie->setClass($datum['class']);
            $movie->setDirectors(json_encode($datum['directors']));
            $movie->setDuration($datum['duration']);
            $movie->setGenres(isset($datum['genres']) ? json_encode($datum['genres']) : '');
            $movie->setHeadline($datum['headline']);
            $movie->setKeyArtImages(json_encode($datum['keyArtImages']));
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
