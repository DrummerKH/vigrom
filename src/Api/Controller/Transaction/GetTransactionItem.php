<?php


namespace App\Api\Controller\Transaction;


use App\Api\Factory\Transaction\TransactionFactory;
use App\Api\Resource\Transaction\TransactionResource;
use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetTransactionItem extends AbstractController
{
    private TransactionFactory $transactionFactory;
    private TransactionRepository $transactionRepository;

    public function __construct(TransactionFactory $transactionFactory, TransactionRepository $transactionRepository)
    {
        $this->transactionFactory = $transactionFactory;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @param int $id
     * @return TransactionResource
     */
    public function __invoke(int $id): TransactionResource
    {
        $transaction = $this->transactionRepository->find($id);

        if (null === $transaction) {
            throw new NotFoundHttpException('Transaction not found');
        }

        return $this->transactionFactory->createFromEntity($transaction);
    }
}