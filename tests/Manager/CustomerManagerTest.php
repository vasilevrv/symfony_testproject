<?php

namespace App\Tests\Manager;

use App\Entity\Customer;
use App\Manager\CustomerManager;
use App\Model\Customers\Command;
use App\Repository\CustomerRepository;
use PHPUnit\Framework\TestCase;

class CustomerManagerTest extends TestCase
{
    public function testCreate(): void
    {
        $repository = $this->getMockBuilder(CustomerRepository::class)->disableOriginalConstructor()->getMock();
        $repository->expects(self::once())->method('save');

        $now = new \DateTime();

        $command = new Command\Create();
        $command->firstName = 'TEST1';
        $command->lastName = 'TEST2';
        $command->birthDate = $now;
        $command->gender = Customer::GENDER_MALE;
        $command->email = 'c1@c2.com';
        $command->address = '';

        $manager = new CustomerManager($repository);
        $note = $manager->create($command);

        self::assertEquals('TEST1', $note->getFirstName());
        self::assertEquals('TEST2', $note->getLastName());
        self::assertEquals($now, $note->getBirthDate());
        self::assertEquals(Customer::GENDER_MALE, $note->getGender());
        self::assertEquals('c1@c2.com', $note->getEmail());
        self::assertEquals('', $note->getAddress());
    }

    public function testUpdate(): void
    {
        $repository = $this->getMockBuilder(CustomerRepository::class)->disableOriginalConstructor()->getMock();
        $repository->expects(self::once())->method('update');

        $note = new Customer('TEST_FN', 'TEST_LN', new \DateTime(), Customer::GENDER_FEMALE, 'v1@v2.com', '');

        $now = new \DateTime();

        $command = new Command\Update();
        $command->firstName = 'TEST1';
        $command->lastName = 'TEST2';
        $command->birthDate = $now;
        $command->gender = Customer::GENDER_MALE;
        $command->email = 'c1@c2.com';
        $command->address = '';

        $manager = new CustomerManager($repository);
        $manager->update($note, $command);

        self::assertEquals('TEST1', $note->getFirstName());
        self::assertEquals('TEST2', $note->getLastName());
        self::assertEquals($now, $note->getBirthDate());
        self::assertEquals(Customer::GENDER_MALE, $note->getGender());
        self::assertEquals('c1@c2.com', $note->getEmail());
        self::assertEquals('', $note->getAddress());
    }
}