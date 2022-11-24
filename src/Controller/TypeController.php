<?php

namespace App\Controller;

use App\Entity\Type;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TypeController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/api/types', name: 'types', methods: ['GET'])]
    public function getTypeList(TypeRepository $typeRepository): JsonResponse
    {
        $typeList = $typeRepository->findAll();
        $jsonTypeList = $this->serializer->serialize($typeList, 'json', ['groups' => 'getTypes']);
        return new JsonResponse($jsonTypeList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/types/{id}', name: 'detailType', methods: ['GET'])]
    public function getDetailBook(Type $type): JsonResponse
    {
        $jsonType = $this->serializer->serialize($type, 'json', ['groups' => 'getTypes']);
        return new JsonResponse($jsonType, Response::HTTP_OK, [], true);
    }
}
