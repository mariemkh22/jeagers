<?php

namespace App\Form;

use App\Entity\Livraison;
use App\Entity\LocalisationGeographique;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivraisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('DateDebut')
            ->add('DateFin')
            ->add('entreprise', ChoiceType::class, [
                'choices'=>[
                    'Aramex' => 'Aramex',
                    'FedEX' => 'FedEX',
                    'JTM' => 'JTM',
                ],
                'placeholder' => 'Select a entreprise',
            ])
            ->add('frais', ChoiceType::class, [
                'choices'=>[
                    24 => 24,
                    3  => 3,
                    1  => 1,
                ],
                'placeholder' => 'Select frais',
            ])
            ->add('status', ChoiceType::class, [
                'choices'=>[
                    'completed' => 'COMPLETED',
                    'inprogress' => 'INPROGRESS',
                    'inCompleted' => 'INCOMPLETED',
                ],
                'placeholder' => 'Select a status',
            ])
            ->add('LocalisationGeographique',EntityType::class,[
                'class'=>LocalisationGeographique::class,
            ])
            ->add('ADD',SubmitType::class );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livraison::class,
        ]);
    }
}
