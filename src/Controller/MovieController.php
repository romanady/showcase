<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Service\DataManager\MovieManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/movie")
 */
class MovieController extends AbstractController
{

    /**
     * @Route("/", name="movie_index", methods={"GET"})
     * @param Request $request
     * @param MovieRepository $movieRepository
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(
        Request $request,
        MovieRepository $movieRepository,
        MovieManager $movieManager,
        PaginatorInterface $paginator
    ): Response
    {
        try {
            $page = $request->query->get('page', 1);
            // Check if we have data stored
            if (!count($movieRepository->hasMovies())) {
                // Otherwise store it
                $movieManager->storeData();
            }

            $moviesQuery = $movieRepository->loadMoviesQuery();
            $pagination = $paginator->paginate(
                $moviesQuery,
                $page,
                $movieRepository->getPerPage()
            );
            return $this->render('movie/index.html.twig', [
                'pagination' => $pagination,
            ]);

        } catch (\Throwable $exception) {
            // todo show an error message
        }
    }

    /**
     * @Route("/{id}", name="movie_show", methods={"GET"})
     * @param Movie $movie
     * @return Response
     */
    public function show(Movie $movie): Response
    {
        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }
}
