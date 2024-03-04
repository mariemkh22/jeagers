<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EditProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom_produit',TextType::class, [
            'attr' => ['placeholder' => 'Product Name']
        ])
        ->add('type', ChoiceType::class,[
            'choices' => [
                'Electronics' => 'Electronics',
                'Fashin' => 'Fashion',
                'Home' => 'Home',
                'Garden' => 'Garden',
                'Health & Fitness' => 'Health & Fitness',
                'Automative' => 'Automative',
                'Games & Toys' => 'Games & Toys',
                'Books & Media' => 'Books & Media',
            ],
        ])  
        ->add('description', TextType::class, [
            'attr' => ['placeholder' => 'Description']
        ])
        
        ->add('equiv', TextType::class, [
            'attr' => ['placeholder' => 'EquivPrice']
        ])

        ->add('imageFile',VichImageType::class)

        ->add('Update',SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}


