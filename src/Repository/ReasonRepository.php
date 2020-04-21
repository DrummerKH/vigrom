<?php

namespace App\Repository;

use App\Entity\Reason;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reason|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reason|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reason[]    findAll()
 * @method Reason[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReasonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reason::class);
    }
}
