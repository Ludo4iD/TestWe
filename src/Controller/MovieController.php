<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Service\MoviePoster;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class MovieController extends AbstractController
{
    private SerializerInterface $serializer;
    private $moviePoster;

    public function __construct(SerializerInterface $serializer, MoviePoster $moviePoster)
    {
        $this->serializer = $serializer;
        $this->moviePoster = $moviePoster;
    }

    #[Route('/api/movies', name: 'movies', methods: ['GET'])]
    public function getMovieList(MovieRepository $movieRepository): JsonResponse
    {
        $movieList = $movieRepository->findAll();
        $jsonMovieList = $this->serializer->serialize($movieList, 'json', ['groups' => 'getMovies']);
        return new JsonResponse($jsonMovieList, Response::HTTP_OK, [], true);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/api/movies/{id}', name: 'detailMovie', methods: ['GET'])]
    public function getDetailMovie(Movie $movie): JsonResponse
    {
        $jsonMovie = $this->serializer->serialize($movie, 'json', ['groups' => 'getMovies']);
        $arrayMovie = json_decode($jsonMovie, true);
        $urlPoster = $this->moviePoster->fetchApidojoImage($movie->getTitle());
        $arrayMovie["urlposter"] = $urlPoster;
        $jsonMovie = json_encode($arrayMovie);
        return new JsonResponse($jsonMovie, Response::HTTP_OK, [], true);
    }

    #[Route('/api/movies', name:"createMovie", methods: ['POST'])]
    public function createMovie(
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        UrlGeneratorInterface $urlGenerator
    ): JsonResponse {
        $movie = $serializer->deserialize($request->getContent(), Movie::class, 'json');

        $em->persist($movie);
        $em->flush();

        $jsonMovie = $serializer->serialize($movie, 'json', ['groups' => 'getMovies']);

        $location = $urlGenerator->generate('detailMovie', ['id' => $movie->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonMovie, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    #[Route('/api/movies/{id}', name: 'deleteMovie', methods: ['DELETE'])]
    public function deleteMovie(Movie $movie, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($movie);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
