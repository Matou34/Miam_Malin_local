<?php

namespace App\Form;

use App\Entity\Recettes;
use App\Entity\Regions;
use App\Entity\Tags;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RecettesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('re_libelle', TextType::class, [
            'label' => 'Nom de la recette',
            'label_attr' => ['class' => 'form-label'],
            'attr' => ['placeholder' => 'Insérer le nom de la recette'],
        ])

        ->add('imageFile', FileType::class, [
            'required' => false,
            'label' => 'Image de la recette',
            'label_attr' => ['class' => 'form-label'],
            'data_class' => null,
            // 'allow_delete' => false,
            // 'asset_helper' => true,
            // 'download_uri' => false,
            // 'constraints' => [
            // new File([
            //     'maxSize' => '2000000000k',
            //     'maxSizeMessage' => 'fichier trop volumineux, 2MO maximum',
            //     'mimeTypes' => [
            //         'image/png', 'image/jpeg', 'image/jpg', 'image/webp',
            //     ],
            //     'mimeTypesMessage'=>"Formats autorisé: 'image/png', 'image/jpeg', 'image/jpg', 'image/webp',"
            // ])
        // ]
        ])

        ->add('re_nb_personnes', IntegerType::class, [
            'required' => false,
            'label' => 'Nombre de personnes',
            'label_attr' => ['class' => 'form-label'],
        ])

        ->add('re_temps', IntegerType::class, [
            'required' => false,
            'label' => 'Temps total de la recette',
            'label_attr' => ['class' => 'form-label'],
            // autres options ...
        ])
        ->add('re_kcal', IntegerType::class, [        
            'required' => false,
            'label' => 'Calories totales de la recette',
            'label_attr' => ['class' => 'form-label'],
            // autres options ...
        ])

        ->add('re_commentaires', TextareaType::class, [
            'required' => false,
            'label' => 'Commentaires sur la recette',
            'label_attr' => ['class' => 'form-label'],
            'attr' => ['placeholder' => 'Insérer un commentaire']
        ])

        ->add('regions', EntityType::class, [
            'class' => Regions::class,
            'choice_label' => 'reg_libelle',
            'label_attr' => ['class' => 'form-label'],
        ])
        ->add('recette_tags', EntityType::class, [
            'class' => Tags::class,
            'label' => 'Tags',
            'choice_label' => 'ta_libelle',
            'multiple' => true,

        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Suivant',
            'attr' => ['class' => 'btn'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recettes::class,
            
        ]);
    }
}
