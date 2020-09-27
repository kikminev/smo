<?php


namespace App\Controller;

use App\Repository\CustomerRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/customers", methods={"GET"})
 */
class CustomersController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * List customers
     *
    * @Route("/"), methods={"GET"}
    */
    public function customers(CustomerRepository $customerRepository):Response
    {
        $customers = $customerRepository->findAll();

        // find token of account

        return new JsonResponse($this->serializer->serialize($customers, 'json'), 200, [], true);
    }
}
