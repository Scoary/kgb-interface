<?php

namespace App\Form;

use App\Entity\Agents;
use App\Entity\Contacts;
use App\Entity\Countries;
use App\Entity\Missions;
use App\Entity\MissionTypes;
use App\Entity\Skills;
use App\Entity\Stashs;
use App\Entity\StatusMissions;
use App\Entity\Targets;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class  MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status_mission', EntityType::class, [
                'class' => StatusMissions::class,
                'label' => 'Statut de la mission'
            ])
            ->add('title', TextType::class, [
                    'required' => true,
                    'label' => 'Titre de la mission',
                    'attr' => [
                        'placeholder' => 'Entrez un titre'
                    ]
            ])
            ->add('description', TextareaType::class , [
                'required' => true,
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Entrez une description'
                ]
            ])
            ->add('code_name', TextType::class, [
                'required' => true,
                'label' => 'Nom de code de la mission',
                'attr' => [
                    'placeholder' => 'Entrez un nom de code'
                ]
            ])
            ->add('start_date', DateType::class, [
                'required' => true,
                'label' => 'Date du début de la mission',
                'widget' => 'choice',
                'format' => 'd M y',
                'years' => range(date("Y"), 2030),
            ])
            ->add('end_date', DateType::class, [
                'required' => true,
                'label' => 'Date de fin de la mission',
                'widget' => 'choice',
                'format' => 'd M y',
                'years' => range(date("Y"), 2030),
            ])
            ->add('skill', EntityType::class, [
                'required' => true,
                'class' => Skills::class,
                'label' => 'Compétence requise'
            ])
            ->add('mission_type', EntityType::class, [
                'required' => true,
                'class' => MissionTypes::class,
                'label' => 'Type de mission'
            ])
            ->add('country', EntityType::class, [
                'required' => true,
                'class' => Countries::class,
                'label' => 'Pays'
            ])
            ->add('stashs', EntityType::class, array(
                'choice_label' => function ($stashs) {
                    return $stashs->getAlias() . " (" . $stashs->getCountry() . ")";
                },
                'class' => Stashs::class,
                'multiple' => true,
                'expanded' => true,
                'required' => true,
                'label' => 'Planque ( Sélectionnez une seule planque correspondant au pays de la mission )'
            ))
            ->add('targets', EntityType::class, array(
                'choice_label' => function ($targets) {
                    return $targets->getAlias() . " (" . $targets->getCountry() . ")";
                },
                'class' => Targets::class,
                'multiple' => true,
                'expanded' => true,
                'required' => true,
                'label' => 'Cible(s) ( Située(s) dans le pays de la mission )'
            ))
            ->add('agents', EntityType::class, array(
                'choice_label' => function ($agents) {
                    return $agents->getAlias() . " (" . $agents->getCountry() . " | Compétences :  ".  implode(", ", $agents->displaySkills()) . ")";
                },
                'class' => Agents::class,
                'multiple' => true,
                'expanded' => true,
                'required' => true,
                'label' => "Agent(s) ( D'un pays différent que celui de la mission )"
            ))
            ->add('contacts', EntityType::class, array(
                'class' => Contacts::class,
                'choice_label' => function ($contacts){
                    return $contacts->getCodeName() . " (" . $contacts->getCountry() . ")";
                },
                'multiple' => true,
                'expanded' => true,
                'required' => true,
                'label' => 'Contact(s) ( Situé(s) dans le pays de la mission )'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Missions::class,
        ]);
    }
}
