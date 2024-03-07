<?php

namespace App\Form;

use App\Entity\Livraison;
use App\Entity\LocalisationGeographique;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class LivraisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('DateDebut',DateType::class, [
                'widget' => 'single_text',
                'attr' => ['placeholder' => 'DateDebut'],
                'html5' => true,
            ])
            ->add('DateFin',DateType::class, [
                'widget' => 'single_text',
                'attr' => ['placeholder' => 'DateFin'],
                'html5' => true,
            ])
            ->add('entreprise', ChoiceType::class, [
                'choices' => [
                    'Aramex' => 'Aramex',
                    'FedEX' => 'FedEX',
                    'JTM' => 'JTM',
                ],
                'placeholder' => 'Select the company',
                ])
            ->add('frais', ChoiceType::class, [
                'choices' => [
                    24 => 24,
                    15 => 15,
                    7 => 7,
                ],
                'placeholder' => 'Select the fees'
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'completed' => 'Completed',
                    'in progress' => 'In progress',
                    'not completed' => 'Not completed',
                ],
                'placeholder' => 'Select the status',
                ])
            ->add('localisationGeographique', EntityType::class, [
                'class' => LocalisationGeographique::class,
                'choice_label' => 'region'
            ])
            ->add('Add_delivery', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livraison::class,
        ]);
    }
}
