<?php

namespace App\DataFixtures;

use App\Entity\Subscription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Pricing extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $subscription1 = new Subscription();
        $subscription1->setTitle('Free');
        $subscription1->setDescription('For small teams or personal use');
        $subscription1->setPrice(0);
        $subscription1->setPdfLimit(5);
        $subscription1->setMedia('free.svg');

        $subscription2 = new Subscription();
        $subscription2->setTitle('Pro');
        $subscription2->setDescription('For growing teams');
        $subscription2->setPrice(10);
        $subscription2->setPdfLimit(50);
        $subscription2->setMedia('pro.svg');

        $subscription3 = new Subscription();
        $subscription3->setTitle('Enterprise');
        $subscription3->setDescription('For large teams');
        $subscription3->setPrice(20);
        $subscription3->setPdfLimit(200);
        $subscription3->setMedia('enterprise.svg');


        $manager->persist($subscription1);
        $manager->persist($subscription2);
        $manager->persist($subscription3);
        $manager->flush();
    }
}
