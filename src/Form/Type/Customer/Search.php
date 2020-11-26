<?php

declare(strict_types=1);

namespace App\Form\Type\Customer;

use App\Form\AbstractAPI;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Model\Customers\Command;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Search extends AbstractAPI
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('value', TextType::class, ['empty_data' => ''])
            ->add('orderBy', TextType::class, ['empty_data' => 'id'])
            ->add('direction', TextType::class, ['empty_data' => 'asc']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefault('allow_extra_fields', true);
    }

    protected function getDataClass(): string
    {
        return Command\Search::class;
    }
}