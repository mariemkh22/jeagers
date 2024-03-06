<?php

namespace App\Form;

use App\Entity\LocalisationGeographique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;

class LocalisationGeographiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('region', ChoiceType::class, [
            'choices' => [
                'Kebili' => 'Kebili',
                'Tunis' => 'Tunis',
                'Nabeul' => 'Nabeul',
                'Gabes' => 'Gabes',
                'Mistir' => 'Mistir',
            ],
            'placeholder' => 'Select a region',
            'constraints' => [
                new NotBlank(['message' => 'Le champ région ne peut pas être vide']),
                new Choice([
                    'choices' => ['Kebili', 'Tunis', 'Nabeul', 'Gabes', 'Mounistir'],
                    'message' => 'Veuillez sélectionner une région valide',
                ]),
            ],
        ])
            ->add('codepostal')
            ->add('adresse')
            ->add('Add_localisation',SubmitType::class );
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LocalisationGeographique::class,
        ]);
    }
}
