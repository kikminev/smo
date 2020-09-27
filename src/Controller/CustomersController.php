<?php


namespace App\Controller;

use App\Repository\CustomerRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/customers", methods={"GET"})
 */
class CustomersController
{
    /**
     * List customers
     *
    * @Route("/"), methods={"GET"}
    */
    public function customers(CustomerRepository $customerRepository):JsonResponse
    {
        $customers = (array) $customerRepository->findAll();

        $customer = $customers[0];
        $test = [$customer];

        return new JsonResponse($test);
    }
}
