<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\Currency;
use App\Entity\Wallet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class Wallets extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /** @var Account[] $accounts */
        $accounts = $manager->getRepository(Account::class)->findAll();
        /** @var Currency[] $currencies */
        $currencies = $manager->getRepository(Currency::class)->findAll();

        foreach ($accounts as $account) {
            $wallet = new Wallet();
            $wallet->setAccount($account);
            $wallet->setCurrency($currencies[array_rand($currencies)]);
            $manager->persist($wallet);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            Accounts::class,
            Currencies::class,
        ];
    }
}
