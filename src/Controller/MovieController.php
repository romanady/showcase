<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use \App\Service\PageLoader\PageLoaderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/movie")
 */
class MovieController extends AbstractController
{
    /**
     * @Route("/", name="movie_index", methods={"GET"})
     */
    public function index(Request $request, PageLoaderInterface $pageLoader, MovieRepository $movieRepository): Response
    {
        $page = $request->query->get('page', 1);
        $movies = [];
        try {
            $movies = $pageLoader->loadData($page);
        } catch (\Exception $exception) {
            // todo show an error message
        }
        $totalMovies = $movieRepository->getTotalMovies();
        return $this->render('movie/index.html.twig', [
            'movies' => $movies,
            'nbPages' => $totalMovies / $movieRepository->getPerPage(),
            'currentPage' => $page,
            'total' => $totalMovies
        ]);
    }

    /**
     * @Route("/{id}", name="movie_show", methods={"GET"})
     */
    public function show(Movie $movie): Response
    {
        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }
}
