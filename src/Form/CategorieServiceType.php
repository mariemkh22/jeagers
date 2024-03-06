<?php

namespace App\Form;

use App\Entity\CategorieService;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class CategorieServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nameC', ChoiceType::class, [
            'label' => 'Category name',
            'choices' => [
                'Select category ' => 1,
                'Educational barter' => 2,
                'DIY services' => 3,
                'Health and wellness services' => 4,
                'Cleaning services' => 5,
                'Sports services' => 6,
                'Entertainment services' => 7,
                'Transportation services' => 8,
                'Other services' => 9,
            ],
            'attr' => [
                'class' => 'form-control',
            ],
        ])
            ->add('descriptionC', TextType::class, [
                'attr' => ['placeholder' => 'Educational barter description']
                ])

            ->add('Submit',SubmitType::class);
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategorieService::class,
        ]);
    }
}
