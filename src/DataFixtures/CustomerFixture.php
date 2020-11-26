<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CustomerFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $customer = new Customer('TEST_FN', 'TEST_LN', new \DateTime(), Customer::GENDER_MALE, 'v1@v2.com', '');
        $manager->persist($customer);
        $manager->flush();
    }
}
