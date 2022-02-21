<?php

namespace App\Form;

use App\Entity\Contacts;
use App\Entity\Countries;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'required' => true
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'required' => true
            ])
            ->add('date_of_birth', DateType::class, [
                'label' => 'Date de naissance',
                'required' => true,
                'widget' => 'choice',
                'format' => 'd M y',
                'years' => range(date("Y") - 75, date("Y") - 18)
            ])
            ->add('code_name', TextType::class, [
                'label' => 'Alias'
            ])
            ->add('country', EntityType::class, [
                'label' => 'Pays',
                'class' => Countries::class,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contacts::class,
        ]);
    }
}
