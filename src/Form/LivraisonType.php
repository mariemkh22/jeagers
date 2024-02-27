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
                'placeholder' => 'Select a entreprise',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le champ entreprise ne peut pas être vide']),
                    new Assert\Length(['max' => 255, 'maxMessage' => 'La longueur maximale est de 255 caractères']),
                ],
            ])
            ->add('frais', ChoiceType::class, [
                'choices' => [
                    24 => 24,
                    3 => 3,
                    1 => 1,
                ],
                'placeholder' => 'Select frais',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le champ frais ne peut pas être vide']),
                    new Assert\Type(['type' => 'integer', 'message' => 'La valeur doit être un nombre entier']),
                ],
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'completed' => 'COMPLETED',
                    'inprogress' => 'INPROGRESS',
                    'inCompleted' => 'INCOMPLETED',
                ],
                'placeholder' => 'Select a status',
                ])
            ->add('localisationGeographique', EntityType::class, [
                'class' => LocalisationGeographique::class,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le champ localisation géographique ne peut pas être vide']),
                ],
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
