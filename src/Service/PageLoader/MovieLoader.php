<?php

namespace App\Service\PageLoader;

use \App\Repository\MovieRepository;
use \App\Service\DataManager\DataManagerInterface;

class MovieLoader implements PageLoaderInterface
{
    /** @var MovieRepository  */
    private $movieRepository;

    /** @var DataManagerInterface */
    private $dataManager;

    public function __construct(
        MovieRepository $movieRepository,
        DataManagerInterface $dataManager
    )
    {
        $this->movieRepository = $movieRepository;
        $this->dataManager = $dataManager;
    }

    public function loadData($page)
    {
        // Check if we have data stored
        if (!count($this->movieRepository->hasMovies())) {
            // Otherwise store it
            $this->dataManager->storeData();
        }
        $movies = $this->movieRepository->loadMovies($page);

        return $movies;
    }
}
