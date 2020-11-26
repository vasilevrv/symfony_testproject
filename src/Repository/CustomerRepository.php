<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Customer;
use App\Model\Customers\Command;
use App\Pagination\Paginator\QueryBuilderPaginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    public function search(Command\Search $command): QueryBuilderPaginator
    {
        $qb = $this->createQueryBuilder('c')
            ->orderBy('c.'.$command->orderBy, strtoupper($command->direction));

        if ($command->value) {
            $qb->andWhere('c.firstName LIKE :value OR c.lastName LIKE :value')
                ->setParameter('value', '%'.$command->value.'%');
        }

        return new QueryBuilderPaginator($qb);
    }

    public function update(Customer $customer): void
    {
        $this->getEntityManager()->flush($customer);
    }

    public function save(Customer $customer): void
    {
        $this->getEntityManager()->persist($customer);
        $this->getEntityManager()->flush($customer);
    }

    public function remove(Customer $customer): void
    {
        $this->getEntityManager()->remove($customer);
        $this->getEntityManager()->flush();
    }
}