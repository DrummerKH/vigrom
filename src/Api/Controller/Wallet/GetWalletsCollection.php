<?php


namespace App\Api\Controller\Wallet;


use App\Api\Factory\Wallet\WalletFactory;
use App\Api\Resource\Wallet\WalletResource;
use App\Entity\Wallet;
use App\Repository\WalletRepository;
use App\Service\WalletManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetWalletsCollection extends AbstractController
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

    /**
     * @return WalletResource[]
     */
    public function __invoke(): array
    {
        $wallets = $this->walletRepository->findAll() ?? [];

        return array_map(function (Wallet $wallet) {
            $balance = $this->walletManager->getBalance($wallet);
            return $this->walletMapper->createFromEntity($wallet, $balance);
        }, $wallets);
    }
}