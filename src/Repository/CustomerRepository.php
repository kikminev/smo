<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    /**
     * @param string $businessUnitToken
     *
     * @return Customer[] Returns an array of Customer objects
     */
    public function findByBusinessUnitToken(string $businessUnitToken, int $maxResult, int $offset)
    {
        return $this->createQueryBuilder('c')
            ->select('c, b')
            ->innerJoin('c.businessUnit', 'b')
            ->andWhere('b.apiToken = :token')
            ->setParameter('token', $businessUnitToken)
            ->setMaxResults($maxResult)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }
}
