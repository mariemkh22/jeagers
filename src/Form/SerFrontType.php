<?php

namespace App\Form;

use App\Entity\CategorieService;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SerFrontType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nameS', TextType::class, [
            'attr' => ['placeholder' => 'Cleaning service']
            ])
        ->add('descriptionS', TextType::class, [
            'attr' => ['placeholder' => 'Cleaning service description']
            ])
        ->add('localisation', ChoiceType::class, [
                'label' => 'Location',
                'choices' => [
                    'Gabes' => 1,
                    'Monastir' => 2,
                    'Tunis' => 3,
                    'Nabeul' => 4,
                    'Kebilli' => 5,
                    'Sousse' => 6,
                    'Bizerte' => 7,
                    'Tunis' => 8,
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('state', TextType::class, [
                'attr' => ['placeholder' => 'Available']
            ])
            ->add('dispoDate', TextType::class, [
                'attr' => ['placeholder' => 'dd/mm/yyyy']
            ])
            ->add('categorie', EntityType::class, [
                'class' => CategorieService::class,
                    ])
            
            ->add('Submit',SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
