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
     * @param int $maxResult
     * @param int $offset
     * @param int|null $customerId
     * @return Customer[] Returns an array of Customer objects
     */
    public function findByBusinessUnitToken(
        string $businessUnitToken,
        int $maxResult,
        int $offset,
        int $customerId = null
    ): array {
        $qb = $this->createQueryBuilder('c')
            ->select('c, b')
            ->innerJoin('c.businessUnit', 'b')
            ->andWhere('b.apiToken = :token')->setParameter('token', $businessUnitToken);

        if (null !== $customerId) {
            $qb->andWhere('c.id = :id')->setParameter('id', $customerId);
        }

        return $qb->setMaxResults($maxResult)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }
}
