<?php

namespace App\Form;

use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TypeTextType::class, [
                'attr' => ['placeholder' => 'example@swapcraze.tn']
            ])
            ->add('full_name', TypeTextType::class, [
                'attr' => ['placeholder' => 'Yassine Ben Mabrouk']
            ])
            ->add('phone_number',TypeTextType::class, [
                'attr' => ['placeholder' => '71 221 332']
            ])
            ->add('date_of_birth', TypeTextType::class, [
                'attr' => ['placeholder' => 'dd/mm/yyyy']
            ])
            ->add('password',PasswordType::class)
            ->add('Sign_up',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}