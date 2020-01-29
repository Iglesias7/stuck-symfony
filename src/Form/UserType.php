<?php

namespace App\Form;

// use App\Entity\Role;
use App\Entity\Role;
use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Pseudo')
            ->add('Password')
            ->add('LastName')
            ->add('FirstName')
            ->add('Email')
            ->add('BirthDate', DateType::class)
            ->add('Role', ChoiceType::class, [
                'choices'  => [
                    'Member' => Role::Member,
                    'Manager' => Role::Manager,
                    'Admin' => Role::Admin,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
