<?php

namespace App\Model\Customers\Command;

use Symfony\Component\Validator\Constraints as Assert;

class Search
{
    /**
     * @Assert\Length(max="100")
     */
    public string $value = '';

    /**
     * @Assert\NotNull()
     * @Assert\Choice(choices={"id", "firstName", "lastName", "birthDate", "gender", "email", "address"})
     */
    public string $orderBy = 'id';

    /**
     * @Assert\NotNull()
     * @Assert\Choice(choices={"asc", "desc"})
     */
    public string $direction = 'asc';
}