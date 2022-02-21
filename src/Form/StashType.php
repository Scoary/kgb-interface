<?php

namespace App\Form;

use App\Entity\Countries;
use App\Entity\Stashs;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StashType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('alias')
            ->add('address', TextType::class, [
                'label' => 'Adresse de la planque'
            ])
            ->add('type')
            ->add('country', EntityType::class, [
                'label' => 'Pays',
                'class' => Countries::class,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stashs::class,
        ]);
    }
}
