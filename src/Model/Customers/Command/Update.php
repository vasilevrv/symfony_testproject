<?php

declare(strict_types=1);

namespace App\Model\Customers\Command;

use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Customer;

class Update
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="100")
     */
    public string $firstName = '';

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="100")
     */
    public string $lastName = '';

    /**
     * @Assert\NotNull()
     * @Assert\GreaterThan("-60 years")
     * @Assert\LessThan("-18 years")
     */
    public ?\DateTime $birthDate;

    /**
     * @Assert\NotBlank()
     * @Assert\Choice({Customer::GENDER_MALE, Customer::GENDER_FEMALE})
     */
    public int $gender;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public string $email;

    /**
     * @Assert\Length(min="0", max="200")
     */
    public string $address = '';
}