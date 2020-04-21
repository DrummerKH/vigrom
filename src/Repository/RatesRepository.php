<?php

namespace App\Repository;

use App\Entity\Currency;
use App\Entity\Rates;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Rates|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rates|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rates[]    findAll()
 * @method Rates[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RatesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rates::class);
    }

    /**
     * @param Currency $currency
     * @return Rates[] Returns an array of Rates objects
     */
    public function getLastRateByCurrency(Currency $currency)
    {
        return $this->createQueryBuilder('r')
            ->select('r.rate')
            ->join('r.currency', 'c')
            ->andWhere('c = :currency')
            ->setParameter('currency', $currency)
            ->orderBy('r.date', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }
}
