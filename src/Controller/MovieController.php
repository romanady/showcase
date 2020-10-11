<?php

namespace App\Controller;

use App\Entity\Movie;
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
    public function index(Request $request, PageLoaderInterface $pageLoader): Response
    {
        $page = $request->query->get('page', 0);
        try {
            $movies = $pageLoader->loadData($page);
        } catch (\Exception $exception) {
            // todo show an error message
            var_dump($exception->getMessage());
            var_dump($exception->getTraceAsString());
        }
        //'total' => count($movieRepository->findAll())
        return $this->render('movie/index.html.twig', [
            'movies' => $movies
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
