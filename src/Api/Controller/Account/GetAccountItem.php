<?php
/**
 * LLC "UTS"
 * Dmitry Hvorostyuk <d.hvorostyuk@hotelbook.ru>
 * Date: 21.04.2020
 */

namespace App\Api\Controller\Account;


use App\Api\Factory\Account\AccountFactory;
use App\Api\Resource\Account\AccountResource;
use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetAccountItem extends AbstractController
{
    private AccountRepository $accountRepository;
    private AccountFactory $accountMapper;

    public function __construct(AccountRepository $accountRepository, AccountFactory $accountMapper)
    {
        $this->accountRepository = $accountRepository;
        $this->accountMapper = $accountMapper;
    }

    /**
     * @param int $id
     * @return AccountResource
     */
    public function __invoke(int $id): AccountResource
    {
        $account = $this->accountRepository->find($id);

        if (null === $account) {
            throw new NotFoundHttpException('Account not found');
        }

        return $this->accountMapper->createFromEntity($account);
    }
}