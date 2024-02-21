<?php

namespace App\Form;
use App\Entity\Produit;
use App\Entity\Commande;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
        ->add('DateCmd', DateType::class, [
            'widget' => 'single_text',
            'attr' => ['placeholder' => 'Date of Command'],
            'html5' => true,
        ])

        ->add('ville', ChoiceType::class,[
            'choices' => [
                'Tunis' => 'Tunis',
                'Nabeul' => 'Nabeul',
                'Gbili' => 'Gbili',
            ],
        ])  

        ->add('methode_livraison', ChoiceType::class,[
            'choices' => [
                'Regular' => 'Regular',
                'Express' => 'Express',
             
            ],
        ])  
         
       

      ->add('Produit',EntityType::class, [
                'class'=>Produit::class,
            ])



      ->add('ADD',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
