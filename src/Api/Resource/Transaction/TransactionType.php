<?php


namespace App\Api\Resource\Transaction;


use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class TransactionType extends AbstractEnumType
{
    public const DEBIT = 'debit';
    public const CREDIT = 'credit';

    protected static $choices = [
        self::DEBIT => 'Debit',
        self::CREDIT => 'Credit',
    ];
}