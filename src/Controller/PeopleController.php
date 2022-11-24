<?php

namespace App\Controller;

use App\Entity\People;
use App\Repository\PeopleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class PeopleController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/api/peoples', name: 'peoples', methods: ['GET'])]
    public function getPeopleList(PeopleRepository $peopleRepository): JsonResponse
    {
        $peopleList = $peopleRepository->findAll();
        $jsonPeopleList = $this->serializer->serialize($peopleList, 'json', ['groups' => 'getPeoples']);
        return new JsonResponse($jsonPeopleList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/peoples/{id}', name: 'detailPeople', methods: ['GET'])]
    public function getDetailBook(People $people): JsonResponse
    {
        $jsonPeople = $this->serializer->serialize($people, 'json', ['groups' => 'getPeoples']);
        return new JsonResponse($jsonPeople, Response::HTTP_OK, [], true);
    }
}
