<?php

namespace App\Form;

use App\Entity\Cuisson;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CuissonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cu_libelle' , TextType::class, [ 
                'label' => 'Titre du mode de cuisson  : ',
                'label_attr' => ['class' => 'form-label'],
                'attr' => [
                    'placeholder' => 'Insérer un mode de cuisson'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => ['class' => 'btn']
            ]);
            
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cuisson::class,
        ]);
    }
}
