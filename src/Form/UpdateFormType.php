<?php

namespace App\Form;

use App\Entity\Service;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateFormType extends AbstractType
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
        ->add('dispoDate', TextType::class, [
            'attr' => ['placeholder' => 'dd/mm/yyyy']
        ])
        ->add('localisation', TextType::class, [
            'attr' => ['placeholder' => 'Gabes']
            ])
        ->add('state', TextType::class, [
            'attr' => ['placeholder' => 'Available']
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
