<?php


namespace App\Controller;

use App\Entity\Customer;
use App\Pagination\OffsetCalculator;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class CustomersController
{
    private SerializerInterface $serializer;
    private EntityManagerInterface $entityManager;

    public function __construct(SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
    }

    /**
     * List customers
     *
     * @Route("/customers/{id}", methods={"GET"})
     * @param CustomerRepository $customerRepository
     * @return Response
     */
    public function customers(CustomerRepository $customerRepository, OffsetCalculator $offsetCalculator, int $id = null):Response
    {

        // require the Content-Type header be set to application/json or throw a 415 Unsupported Media Type HTTP
        // some test string
        $token = '789mGTmVTKOd8Lvfft789mGTm43fhVTghg8Lvfft';
        $page = 1;

        $customers = $customerRepository->findByBusinessUnitToken($token, OffsetCalculator::DEFAULT_ITEMS_PER_PAGE, OffsetCalculator::calculate($page), $id);

        return new JsonResponse($this->serializer->serialize($customers, 'json'), 200, [], true);
    }

    /**
     * Update customer
     * @Route("/customers/{id}", methods={"PATCH"})
     * @param Customer $customer
     * @return Response
     */
    public function updateCustomer(Customer $customer, Request $request, EntityManagerInterface $entityManager):Response {
        // todo: find the customer by business unit

        $data = json_decode($request->getContent(), true);

        $propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()
            ->enableMagicCall()
            ->getPropertyAccessor();

        foreach ($data as $propertyName => $value) {
            $propertyAccessor->setValue($customer, $propertyName, $value);
        }

        $entityManager->persist($customer);
        $entityManager->flush();

        // return what?
        return new Response(json_encode('ok'));
    }

    /**
     * Update customer
     * @Route("/customers", methods={"POST"})
     * @param Customer $customer
     * @return Response
     */
    public function createCustomer(Request $request)
    {
        $data = $request->request->all();
        // VALIDATE
        $customer = new Customer();

        $propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()
            ->enableMagicCall()
            ->getPropertyAccessor();

        foreach ($data as $propertyName => $value) {
            $propertyAccessor->setValue($customer, $propertyName, $value);
        }

        $this->entityManager->persist($customer);
        $this->entityManager->flush();


        echo 'ok'; exit;
        // return 201
    }
    // create customer
    // delete customer
}
