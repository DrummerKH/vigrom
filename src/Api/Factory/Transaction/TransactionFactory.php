<?php


namespace App\Api\Factory\Transaction;


use App\Api\Resource\Transaction\TransactionResource;
use App\Api\Resource\Transaction\TransactionType;
use App\Entity\Transaction;

class TransactionFactory
{
    public function createFromEntity(Transaction $transaction)
    {
        $amount = $transaction->getAmount();
        $type = $amount > 0 ? TransactionType::DEBIT : TransactionType::CREDIT;

        return new TransactionResource(
            $type,
            abs($amount/100),
            $transaction->getWallet()->getCurrency()->getCode(),
            $transaction->getReason()->getName(),
            $transaction->getId()
        );
    }
}