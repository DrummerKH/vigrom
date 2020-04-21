<?php
/**
 * LLC "UTS"
 * Dmitry Hvorostyuk <d.hvorostyuk@hotelbook.ru>
 * Date: 21.04.2020
 */

namespace App\Api\Controller\Account;


use App\Api\Factory\Account\AccountFactory;
use App\Api\Resource\Account\AccountResource;
use App\Entity\Account;
use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetAccountsCollection extends AbstractController
{
    private AccountRepository $accountRepository;
    private AccountFactory $accountMapper;

    public function __construct(AccountRepository $accountRepository, AccountFactory $accountMapper)
    {
        $this->accountRepository = $accountRepository;
        $this->accountMapper = $accountMapper;
    }

    /**
     * @return AccountResource[]
     */
    public function __invoke(): array
    {
        /** @var Account[] $accounts */
        $accounts = $this->accountRepository->findAll();

        return array_map(function (Account $account) {
            return $this->accountMapper->createFromEntity($account);
        }, $accounts);
    }
}