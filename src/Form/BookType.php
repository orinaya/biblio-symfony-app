<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Language;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('desciption')
            ->add('publicationYear', IntegerType::class, [
                'label' => 'Année de publication',
                'required' => false,
            ])
            ->add('image', FileType::class, [
                'label' => 'Image du livre',
                'mapped' => false, // Ce champ n'est pas directement lié à l'entité
                'required' => false,
                'attr' => [
                    'accept' => 'image/*',
                ],
            ])
            ->add('authors', EntityType::class, [
                'class' => Author::class,
                'choice_label' => function (Author $author) {
                    return $author->getFirstname() . ' ' . $author->getLastname();
                },
                'multiple' => true,
                'required' => false,
                'expanded' => false,
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false,
                'expanded' => false,
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false,
                'expanded' => false,
            ])
            ->add('languages', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'language',
                'multiple' => true,
                'expanded' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
