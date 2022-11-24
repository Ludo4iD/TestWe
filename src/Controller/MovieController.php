<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MovieController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/api/movies', name: 'movies', methods: ['GET'])]
    public function getMovieList(MovieRepository $movieRepository): JsonResponse
    {
        $movieList = $movieRepository->findAll();
        $jsonMovieList = $this->serializer->serialize($movieList, 'json', ['groups' => 'getMovies']);
        return new JsonResponse($jsonMovieList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/movies/{id}', name: 'detailMovie', methods: ['GET'])]
    public function getDetailBook(Movie $movie): JsonResponse
    {
        $jsonMovie = $this->serializer->serialize($movie, 'json', ['groups' => 'getMovies']);
        return new JsonResponse($jsonMovie, Response::HTTP_OK, [], true);
    }
}
