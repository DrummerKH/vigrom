<?php


namespace App\Service;


use App\Entity\Currency;
use App\Entity\Reason;
use App\Entity\Transaction;
use App\Entity\Wallet;
use App\Repository\WalletRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\PessimisticLockException;
use LogicException;

class WalletManager
{
    private EntityManagerInterface $entityManager;
    private CurrencyConverter $currencyConverter;
    private WalletRepository $walletRepository;

    public function __construct(EntityManagerInterface $entityManager, CurrencyConverter $currencyConverter, WalletRepository $walletRepository)
    {
        $this->entityManager = $entityManager;
        $this->currencyConverter = $currencyConverter;
        $this->walletRepository = $walletRepository;
    }

    /**
     * @param Wallet $wallet
     * @param int $amount
     * @param Currency $baseCurrency
     * @param Reason $reason
     * @return Transaction
     * @throws OptimisticLockException
     * @throws PessimisticLockException
     */
    public function makeTransaction(Wallet $wallet, int $amount, Currency $baseCurrency, Reason $reason): Transaction
    {
        if ($wallet->getCurrency() !== $baseCurrency) {
            $amount = $this->currencyConverter->convert($amount, $baseCurrency, $wallet->getCurrency());
        }

        $this->entityManager->beginTransaction();
        $this->entityManager->lock($wallet, LockMode::PESSIMISTIC_WRITE);

        $balance = $this->getBalance($wallet);

        if($balance + $amount < 0) {
            throw new LogicException('Not enough funds');
        }

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setReason($reason);
        $transaction->setWallet($wallet);

        $this->entityManager->persist($transaction);
        $this->entityManager->flush();
        $this->entityManager->commit();

        return $transaction;
    }

    /**
     * @param Wallet $wallet
     * @return int
     */
    public function getBalance(Wallet $wallet): int
    {
        return $this->walletRepository->getBalance($wallet) ?? 0;
    }
}