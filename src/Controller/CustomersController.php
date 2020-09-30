<?php


namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

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
     * @Route("/customers", methods={"GET"})
     * @param CustomerRepository $customerRepository
     * @return Response
     */
    public function customers(CustomerRepository $customerRepository):Response
    {
        // some test string
        $token = '789mGTmVTKOd8Lvfft789mGTm43fhVTghg8Lvfft';
        // ids
        // limit
        // page
        // sort by

        // validate filters
        //

        $limit = 10;
        $page = 1;
        if(1 == $page) {
            $offset = 0;
        } else {
            $offset = ($limit * $page) - $limit + 1;
        }

        $customers = $customerRepository->findByBusinessUnitToken($token, $limit, $offset);

        return new JsonResponse($this->serializer->serialize($customers, 'json'), 200, [], true);
    }


    /**
     * Update customer
     * @Route("/customers/{id}", methods={"PATCH"})
     * @param Customer $customer
     * @return Response
     */
    public function updateCustomer(Customer $customer, Request $request, EntityManagerInterface $entityManager):Response {

        // validate the info
        $data = json_decode($request->getContent());

        if (isset($data->firstName)) {
            $customer->setFirstName($data->firstName);
        } else if (isset($data->lastName)) {
            $customer->setLastName($data->lastName);
        } else if (isset($data->email)) {
            $customer->setEmail($data->email);
        } else if (isset($data->phone)) {
            $customer->setPhone($data->phone);
        }

        $entityManager->flush();
    }
}
