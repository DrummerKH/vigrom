<?php


namespace App\Api\Controller\Transaction;


use App\Api\Factory\Transaction\TransactionFactory;
use App\Api\Resource\Transaction\TransactionResource;
use App\Api\Resource\Transaction\TransactionType;
use App\Repository\CurrencyRepository;
use App\Repository\ReasonRepository;
use App\Repository\WalletRepository;
use App\Service\WalletManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\PessimisticLockException;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CreateTransaction extends AbstractController
{
    private ReasonRepository $reasonRepository;
    private CurrencyRepository $currencyRepository;
    private WalletRepository $walletRepository;
    private WalletManager $walletService;
    private TransactionFactory $transactionFactory;

    public function __construct(ReasonRepository $reasonRepository, WalletRepository $walletRepository, CurrencyRepository $currencyRepository, WalletManager $walletService, TransactionFactory $transactionFactory)
    {
        $this->reasonRepository = $reasonRepository;
        $this->walletRepository = $walletRepository;
        $this->currencyRepository = $currencyRepository;
        $this->walletService = $walletService;
        $this->transactionFactory = $transactionFactory;
    }

    /**
     * @param int $walletId
     * @param TransactionResource $data
     * @return TransactionResource
     * @throws OptimisticLockException
     * @throws PessimisticLockException
     */
    public function __invoke(int $walletId, TransactionResource $data): TransactionResource
    {
        $wallet = $this->walletRepository->find($walletId);
        if (null === $wallet) {
            throw new NotFoundHttpException('Wallet not found');
        }

        $baseCurrency = $this->currencyRepository->findBy(['code' => $data->currency])[0] ?? null;
        if (null === $baseCurrency) {
            throw new LogicException('Currency is invalid');
        }

        $reason = $this->reasonRepository->findOneBy(['name' => $data->reason]);
        if (null === $reason) {
            throw new LogicException('Reason is invalid');
        }

        $amount = (int)($data->amount * 100);
        switch ($data->type) {
            case TransactionType::CREDIT:
                $amount = -$amount;
        }

        $transaction = $this->walletService->makeTransaction($wallet, $amount, $baseCurrency, $reason);

        return $this->transactionFactory->createFromEntity($transaction);
    }
}