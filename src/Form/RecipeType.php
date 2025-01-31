<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Nom de la recette'],
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Description de la recette'],
            ])
            ->add('slug', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Slug de la recette'],
            ])
            ->add('categorie', EntityType::class , [
                'class' => Category::class,
                'attr' => ['class' => 'form-control'],
                'label' => 'Catégorie de la recette :',
                'label_attr' => ['class' => 'input-label'],
            ])
            ->add('Enregistrer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
