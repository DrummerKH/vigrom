<?php

namespace App\Repository;

use App\Entity\Transaction;
use App\Entity\Wallet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Wallet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wallet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wallet[]    findAll()
 * @method Wallet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WalletRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wallet::class);
    }

    /**
     * @param Wallet $wallet
     * @return int|null
     */
    public function getBalance(Wallet $wallet): ?int
    {
        return $this->_em->createQueryBuilder()
                ->select('t')
                ->from(Transaction::class, 't')
                ->select('SUM(t.amount) as balance')
                ->andWhere('t.wallet = :wallet')
                ->setParameter('wallet', $wallet)
                ->getQuery()
                ->getResult()[0]['balance'] ?? null;
    }
}
