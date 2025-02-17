<?php

namespace App\Form;

use App\Entity\Serie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la série',
            ])
            ->add('overview', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Status',
                'attr' => [
                    'class' => 'form-control custom-select',
                ],
                'choices' => [
                    'Returning' => 'returning',
                    'Ended' => 'ended',
                    'Cancelled' => 'cancelled'
                ]
            ])
            ->add('vote', TextType::class)
            ->add('popularity',TextType::class)
            ->add('genres')
            ->add('firstAirDate', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('lastAirDate', null, [
                'widget' => 'single_text',
            ])
            ->add('backdrop')
            ->add('poster')
            ->add('tmdbId')
            ->add('button', SubmitType::class, [
                'label' => 'Enregistrer votre série'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Serie::class,
        ]);
    }
}
