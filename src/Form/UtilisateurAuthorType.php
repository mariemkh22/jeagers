<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurAuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('full_name', TextType::class, [
                'attr' => ['placeholder' => 'Yassine Ben Mabrouk']
            ])
            ->add('phone_number', TextType::class, [
                'attr' => ['placeholder' => '71 221 332']
            ])
            ->add('password',PasswordType::class)
            ->add('email', TextType::class, [
                'attr' => ['placeholder' => 'example@swapcraze.tn']
            ])
            ->add('date_of_birth', TextType::class, [
                'attr' => ['placeholder' => 'dd/mm/yyyy']
            ])
            ->add('Sign_up',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
