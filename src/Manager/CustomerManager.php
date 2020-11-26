<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Customer;
use App\Model\Customers\Command;
use App\Pagination\Paginator\PaginatorInterface;
use App\Repository\CustomerRepository;

class CustomerManager
{
    private CustomerRepository $repository;

    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function get(int $id): ?Customer
    {
        return $this->repository->find($id);
    }

    public function search(Command\Search $command): PaginatorInterface
    {
        return $this->repository->search($command);
    }

    public function create(Command\Create $command): Customer
    {
        $customer = new Customer(
            $command->firstName,$command->lastName, $command->birthDate, $command->gender, $command->email, $command->address);
        $this->repository->save($customer);

        return $customer;
    }

    public function update(Customer $customer, Command\Update $command): void
    {
        $customer->setFirstName($command->firstName);
        $customer->setLastName($command->lastName);
        $customer->setBirthDate($command->birthDate);
        $customer->setGender($command->gender);
        $customer->setEmail($command->email);
        $customer->setAddress($command->address);

        $this->repository->update($customer);
    }

    public function remove(Customer $customer): void
    {
        $this->repository->remove($customer);
    }
}