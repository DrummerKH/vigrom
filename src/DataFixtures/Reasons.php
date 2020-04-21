<?php

namespace App\DataFixtures;

use App\Entity\Reason;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Reasons extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach (['stock', 'refund'] as $name) {
            $reason = new Reason();
            $reason->setName($name);
            $manager->persist($reason);
        }

        $manager->flush();
    }
}
