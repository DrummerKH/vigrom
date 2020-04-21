<?php

namespace App\Api\Factory\Account;

use App\Api\Resource\Account\AccountResource;
use App\Entity\Account;

class AccountFactory
{
    public function createFromEntity(Account $account): AccountResource
    {
        return new AccountResource($account->getId(), $account->getName());
    }
}