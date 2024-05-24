<?php

namespace App\Form;

use App\Entity\Cuisson;
use App\Entity\Etapes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtapesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('et_numero', IntegerType::class, [ 
                'label' => 'Etapes numero:'  ,
                'label_attr' => ['class' => 'form-label'],
            ])

            ->add('et_description' , TextareaType::class, [ 
                'label' => 'Desciption de l\'étape*  '  ,
                'label_attr' => ['class' => 'form-label'],
                'attr' => ['placeholder' => 'Insérer la description de l\'étape']
            ])

            ->add('cuisson', EntityType::class, [
                'class' => Cuisson::class,
                'required' => false,
                'placeholder' => '',
                'choice_label' => 'cu_libelle',
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => ['class' => 'btn']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etapes::class,
        ]);
    }
}
