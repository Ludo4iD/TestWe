<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MoviePoster
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function fetchApidojoImage(string $title): ?string
    {
        $response = $this->client->request(
            'GET',
            'https://imdb8.p.rapidapi.com/title/v2/find',
            [
                'headers' => [
                    'X-RapidAPI-Key' => '754237601amsh09f935cdb5ffcbfp1d2043jsn05080faa1d70',
                    'X-RapidAPI-Host' => 'imdb8.p.rapidapi.com'
                ],
                'query' => [
                    'title' => $title,
                    'limit' => '20',
                    'sortArg' => 'moviemeter,asc'
                ],
            ]
        );

        $statusCode = $response->getStatusCode();
        if ($statusCode === Response::HTTP_OK) {
            $content = $response->toArray();
            if ($content['totalMatches'] > 0) {
                return $content['results'][0]['image']['url'];
            }
        }

        return null;
    }
}
