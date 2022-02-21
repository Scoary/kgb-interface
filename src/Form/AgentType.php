<?php

namespace App\Form;

use App\Entity\Agents;
use App\Entity\Countries;
use App\Entity\Skills;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgentType extends AbstractType
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
            ->add('alias')
            ->add('country', EntityType::class, [
                'label' => 'Pays',
                'class' => Countries::class,
            ])
            ->add('skills', EntityType::class, [
                'label' => 'Compétence(s)',
                'class' => Skills::class,
                'multiple' => true,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agents::class,
        ]);
    }
}
