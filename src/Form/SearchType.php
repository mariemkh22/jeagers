<?php

namespace App\Form;

use App\Entity\CategorieService;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('categories', EntityType::class, [
            'label' => false,
            'required' => false,
            'class' => CategorieService::class, 
            'choice_label' => 'nameC',
            'multiple' => true,
            'expanded' => true,
        ])
        ->add('string', TextType::class, [
            'label' => 'Localisation',
            'required' => false,
            'attr' => [
                'placeholder' => 'Votre recherche'
            ]
        ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-outline-info w-100'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }

    public function getBlockPrefix() {
        return '';
    }
}
