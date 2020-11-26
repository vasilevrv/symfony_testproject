<?php

declare(strict_types=1);

namespace App\Form\Type\Customer;

use App\Form\AbstractAPI;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Model\Customers\Command;

class Create extends AbstractAPI
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, ['empty_data' => ''])
            ->add('lastName', TextType::class, ['empty_data' => ''])
            ->add('birthDate', DateType::class, ['widget' => 'single_text'])
            ->add('gender', IntegerType::class, ['empty_data' => 0])
            ->add('email', TextType::class, ['empty_data' => ''])
            ->add('address', TextType::class, ['empty_data' => '']);
    }

    protected function getDataClass(): string
    {
        return Command\Create::class;
    }
}