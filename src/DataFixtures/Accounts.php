<?php

namespace App\DataFixtures;

use App\Entity\Account;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class Accounts extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 2; $i > 0; $i--) {
            $account = new Account();
            $account->setName($faker->firstName);
            $manager->persist($account);
        }

        $manager->flush();
    }
}
