<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditCommandeType extends AbstractType
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
    'Ariana' => 'Ariana',
    'Beja' => 'Beja',
    'Ben Arous' => 'Ben Arous',
    'Bizerte' => 'Bizerte',
    'Gabes' => 'Gabes',
    'Gafsa' => 'Gafsa',
    'Jendouba' => 'Jendouba',
    'Kairouan' => 'Kairouan',
    'Kasserine' => 'Kasserine',
    'Kebili' => 'Kebili',
    'Kef' => 'Kef',
    'Mahdia' => 'Mahdia',
    'Manouba' => 'Manouba',
    'Medenine' => 'Medenine',
    'Monastir' => 'Monastir',
    'Nabeul' => 'Nabeul',
    'Sfax' => 'Sfax',
    'Sidi Bouzid' => 'Sidi Bouzid',
    'Siliana' => 'Siliana',
    'Sousse' => 'Sousse',
    'Tataouine' => 'Tataouine',
    'Tozeur' => 'Tozeur',
    'Zaghouan' => 'Zaghouan',
            ],
        ])  

        ->add('methode_livraison', ChoiceType::class,[
            'choices' => [
                'Regular' => 'Regular',
                'Express' => 'Express',
             
            ],
        ])  
         
       
        ->add('produit', EntityType::class, [
            'class' => Produit::class,
            'choice_label' => 'nom_produit',] ) 



            ->add('Update',SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
