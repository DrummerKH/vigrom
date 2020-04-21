<?php

namespace App\Api\Resource\Transaction;

use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class TransactionResource
{
    /**
     * @ApiProperty(identifier=true)
     * @Groups({"transaction:read"})
     */
    public ?int $id;

    /**
     * @Assert\Choice(callback={"App\Api\Resource\Transaction\TransactionType", "getValues"})
     * @Groups({"transaction:create", "transaction:read"})
     */
    public string $type;

    /**
     * @Assert\GreaterThan(0)
     * @Groups({"transaction:create", "transaction:read"})
     */
    public float $amount;

    /**
     * @Assert\Length(min="3", max="3")
     * @Groups({"transaction:create", "transaction:read"})
     */
    public string $currency;

    /**
     * @Groups({"transaction:create", "transaction:read"})
     */
    public string $reason;

    /**
     * Wallet constructor.
     * @param string $type
     * @param float $amount
     * @param string $currency
     * @param string $reason
     * @param int|null $id
     */
    public function __construct(string $type, float $amount, string $currency, string $reason, ?int $id = null)
    {
        $this->type = $type;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->reason = $reason;
        $this->id = $id;
    }
}