<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Platforme;
use App\Entity\ClasseAge;
use App\Entity\Genres;
use App\Entity\Langues;

class ModifArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('libelle', TextType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold']])
        ->add('prix', NumberType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold']])
        ->add('description', TextareaType::class, ['attr' => ['class'=> 'form-control', 'rows'=>'7', 'cols' => '7'], 'label_attr' => ['class'=> 'fw-bold']])
        ->add('editeur', TextType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold']])
        ->add('dev', TextType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold']])
        ->add('qte_stock', NumberType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold']])
        ->add('dateSortie', DateType::class, ['years' => range(1990, 2100),'label_attr' => ['class'=> 'fw-bold']])
        ->add('platforme', EntityType::class, [
            // looks for choices from this entity
            'class' => Platforme::class,
        
            // uses the User.username property as the visible option string
            'choice_label' => 'platforme',
        
            // used to render a select box, check boxes or radios
            // 'multiple' => true,
            // 'expanded' => true,
            'attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold']
        ])
        ->add('classeAge', EntityType::class, [
            // looks for choices from this entity
            'class' => ClasseAge::class,
        
            // uses the User.username property as the visible option string
            'choice_label' => 'pegi',
        
            // used to render a select box, check boxes or radios
            // 'multiple' => true,
            // 'expanded' => true,
            'attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold']
        ])
        ->add('genre', EntityType::class, [
            // looks for choices from this entity
            'class' => Genres::class,
        
            // uses the User.username property as the visible option string
            'choice_label' => 'genre',
        
            // used to render a select box, check boxes or radios
            // 'multiple' => true,
            // 'expanded' => true,
            'attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold']
        ])
        ->add('langue', EntityType::class, [
            
            // looks for choices from this entity
            'class' => Langues::class,
        
            // uses the User.username property as the visible option string
            'choice_label' => 'libelle',
        
            // used to render a select box, check boxes or radios
            'multiple' => true,
            'expanded' => true,
            'attr' => ['class'=> 'form-control',
            'style' => 'display: flex;'], 
            'label_attr' => ['class'=> 'fw-bold'],
            'choice_attr' => function() {
                return ['style' => 'margin-right: 10px;margin-left: 10px;'];
            }
        ])
        ->add('images', FileType::class, [
            'label' => 'Image(s) à telecharger',
            'multiple' => true,
            'mapped' => false,
            'required' => false, 
            'attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold']])
        ->add('envoyer', SubmitType::class, ['attr' => ['class'=> 'btn bg-info text-white m-4' ], 'row_attr' => ['class' => 'text-center'],])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
