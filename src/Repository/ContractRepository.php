<?php

namespace App\Repository;

use App\Entity\Contract;
use App\Entity\RentalObject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method Contract|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contract|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contract[]    findAll()
 * @method Contract[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractRepository extends ServiceEntityRepository
{
    protected $now;

    protected $rentalObject;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contract::class);
    }

    public function getSortedContracts(RentalObject $rentalObject)
    {
        $this->rentalObject = $rentalObject;
        $contracts = [];

        $contracts['Ongoing contract'] = $this->getOngoingContract();
        $contracts['Future contracts'] = $this->getFutureContracts();
        $contracts['Past contracts'] = $this->getPastContracts();

        return $contracts;
    }

    public function getOngoingContract()
    {
        $qb = $this->getBaseQuery();
        $qb
            ->andWhere('c.startDate < :now')
            ->andWhere('c.endDate > :now')
            ->setParameter(':now', $this->getDateNow())
        ;

        return $qb->getQuery()->getResult();
    }

    public function getPastContracts()
    {
        $qb = $this->getBaseQuery();
        $qb
            ->andWhere('c.endDate < :now')
            ->setParameter(':now', $this->getDateNow())
        ;

        return $qb->getQuery()->getResult();
    }

    public function getFutureContracts()
    {
        $qb = $this->getBaseQuery();
        $qb
            ->andWhere('c.startDate > :now')
            ->setParameter(':now', $this->getDateNow())
        ;

        return $qb->getQuery()->getResult();
    }

    protected function getDateNow()
    {
        if ($this->now == null) {
            $this->now = (new \DateTime())->modify('today midnight')->format('Y-m-d H:i:s');
        }

        return $this->now;
    }

    protected function getBaseQuery()
    {
        $qb = $this->createQueryBuilder('c');
        return $qb->where($qb->expr()->eq('c.rentalObject', $this->rentalObject->getId()));

    }
}
