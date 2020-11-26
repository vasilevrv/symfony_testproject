<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 * @ORM\Table(name="customers")
 */
class Customer
{
    public const GENDER_MALE = 0;
    public const GENDER_FEMALE = 1;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"base"})
     *
     */
    protected ?int $id;

    /**
     * @ORM\Column(type="string")
     * @Serializer\Groups({"base"})
     */
    protected string $firstName;

    /**
     * @ORM\Column(type="string")
     * @Serializer\Groups({"base"})
     */
    protected string $lastName;

    /**
     * @ORM\Column(type="date")
     * @Serializer\Groups({"base"})
     */
    protected \DateTime $birthDate;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"base"})
     */
    protected int $gender;

    /**
     * @ORM\Column(type="string")
     * @Serializer\Groups({"base"})
     */
    protected string $email;

    /**
     * @ORM\Column(type="string")
     * @Serializer\Groups({"base"})
     */
    protected string $address;

    public function __construct(string $firstName, string $lastName, \DateTime $birthDate, int $gender, string $email, string $address)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthDate = $birthDate;
        $this->gender = $gender;
        $this->email = $email;
        $this->address = $address;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getBirthDate(): \DateTime
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTime $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    public function getGender(): int
    {
        return $this->gender;
    }

    public function setGender(int $gender): void
    {
        $this->gender = $gender;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }
}
