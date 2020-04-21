<?php

namespace App\DataFixtures;

use App\Entity\Currency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Currencies extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach (['RUB', 'USD', 'EUR'] as $code) {
            $currency = new Currency();
            $currency->setCode($code);
            $manager->persist($currency);
        }

        $manager->flush();
    }
}
