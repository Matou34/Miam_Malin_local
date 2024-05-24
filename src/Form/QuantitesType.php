<?php

namespace App\Form;

use App\Entity\Etapes;
use App\Entity\Produits;
use App\Entity\Quantites;
use App\Entity\Unites;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuantitesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('qu_quantites', IntegerType::class, [ 
                'label' => 'Quantites produits  '  ,
                'required' => false,
                'label_attr' => ['class' => 'form-label'],
                'attr' => [
                    'placeholder' => 'Insérer la quantites'
                ]
            ])

            ->add('unites', EntityType::class, [
                'class' => Unites::class,
                'required' => false,
                'placeholder' => '',
                'choice_label' => 'un_libelle',
                'label_attr' => ['class' => 'form-label'],
            ])


            ->add('produits', EntityType::class, [
                'class' => Produits::class,
                'required' => false,
                'placeholder' => '',
                'choice_label' => 'pr_libelle',
                'label_attr' => ['class' => 'form-label'],
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => ['class' => 'btn'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quantites::class,
        ]);
    }
}
