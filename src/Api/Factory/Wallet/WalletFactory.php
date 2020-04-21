<?php


namespace App\Api\Factory\Wallet;


use App\Api\Factory\Account\AccountFactory;
use App\Api\Resource\Wallet\WalletResource;
use App\Entity\Wallet;

class WalletFactory
{
    private AccountFactory $accountMapper;

    public function __construct(AccountFactory $accountMapper)
    {
        $this->accountMapper = $accountMapper;
    }

    public function createFromEntity(Wallet $wallet, int $balance)
    {
        $account = $this->accountMapper->createFromEntity($wallet->getAccount());

        return new WalletResource(
            $wallet->getId(),
            round($balance/100, 2),
            $wallet->getCurrency()->getCode(),
            $account
        );
    }
}