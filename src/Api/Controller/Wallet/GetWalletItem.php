<?php


namespace App\Api\Controller\Wallet;


use App\Api\Factory\Wallet\WalletFactory;
use App\Api\Resource\Wallet\WalletResource;
use App\Repository\WalletRepository;
use App\Service\WalletManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetWalletItem extends AbstractController
{
    private WalletRepository $walletRepository;
    private WalletFactory $walletMapper;
    private WalletManager $walletManager;

    public function __construct(WalletRepository $walletRepository, WalletFactory $walletMapper, WalletManager $walletManager)
    {
        $this->walletRepository = $walletRepository;
        $this->walletMapper = $walletMapper;
        $this->walletManager = $walletManager;
    }

    public function __invoke(int $id): WalletResource
    {
        $wallet = $this->walletRepository->find($id);

        if (null === $wallet) {
            throw new NotFoundHttpException('Wallet not found');
        }

        $balance = $this->walletManager->getBalance($wallet);

        return $this->walletMapper->createFromEntity($wallet, $balance);
    }
}