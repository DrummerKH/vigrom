<?php

namespace App\Api\Resource\Account;

use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;

class AccountResource
{
    /**
     * @ApiProperty(identifier=true)
     * @Groups({"account:read"})
     */
    public int $id;

    /**
     * @Groups({"account:read"})
     */
    public string $name;

    /**
     * Account constructor.
     * @param int $id
     * @param string $name
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}