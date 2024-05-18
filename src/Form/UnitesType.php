<?php

namespace App\Form;

use App\Entity\Unites;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UnitesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('un_libelle', TextType::class, [ 
            'label' => 'Titre de l\'unuité de mesure :',
            'label_attr' => ['class' => 'form-label'],
            'attr' => [
                'placeholder' => 'Insérer une unité'
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
            'data_class' => Unites::class,
        ]);
    }
}
