<?php

namespace App\Controller;

use App\Entity\People;
use App\Repository\PeopleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
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

    #[Route('/api/peoples', name:"createPeople", methods: ['POST'])]
    public function createPeople(
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        UrlGeneratorInterface $urlGenerator
    ): JsonResponse {
        $people = $serializer->deserialize($request->getContent(), People::class, 'json');
        $em->persist($people);
        $em->flush();

        $jsonPeople = $serializer->serialize($people, 'json', ['groups' => 'getPeoples']);

        $location = $urlGenerator->generate('detailPeople', ['id' => $people->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonPeople, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    #[Route('/api/peoples/{id}', name: 'deletePeople', methods: ['DELETE'])]
    public function deletePeople(People $people, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($people);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
