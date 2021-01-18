<?php

namespace App\Repository;

use App\Entity\RentalObject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RentalObject|null find($id, $lockMode = null, $lockVersion = null)
 * @method RentalObject|null findOneBy(array $criteria, array $orderBy = null)
 * @method RentalObject[]    findAll()
 * @method RentalObject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RentalObjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RentalObject::class);
    }

    // /**
    //  * @return RentalObject[] Returns an array of RentalObject objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RentalObject
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
