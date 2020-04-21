<?php

namespace App\Api\Resource\Wallet;

use ApiPlatform\Core\Annotation\ApiProperty;
use App\Api\Resource\Account\AccountResource;
use Symfony\Component\Serializer\Annotation\Groups;

class WalletResource
{
    /**
     * @ApiProperty(identifier=true)
     * @Groups({"wallet:read"})
     */
    public int $id;

    /**
     * @Groups({"wallet:read"})
     */
    public float $balance;

    /**
     * @Groups({"wallet:read"})
     */
    public string $currency;

    /**
     * @Groups({"account:read"})
     */
    public AccountResource $account;

    /**
     * Wallet constructor.
     * @param int $id
     * @param float $balance
     * @param string $currency
     * @param AccountResource $account
     */
    public function __construct(int $id, float $balance, string $currency, AccountResource $account)
    {
        $this->balance = $balance;
        $this->currency = $currency;
        $this->account = $account;
        $this->id = $id;
    }
}