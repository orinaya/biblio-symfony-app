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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre du livre',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Titre du livre',
                ],
            ])
            ->add('desciption', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Description du livre',
                    'rows' => 5,
                ],
            ])
            ->add('publicationYear', IntegerType::class, [
                'label' => 'Année de publication',
                'required' => false,
                'attr' => [
                    'min' => 1000,
                    'max' => date('Y'),
                    'placeholder' => 'Année de publication',
                ],
            ])
            ->add('isbn', TextType::class, [
                'label' => 'ISBN',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ex: 978-2-1234-5680-3',
                ],
                'help' => 'Format ISBN-10 ou ISBN-13 requis'
            ])
            ->add('image', FileType::class, [
                'label' => 'Image du livre',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'accept' => 'image/*',
                ],
                // 'constraints' => [
                //     new File([
                //         'maxSize' => '50M',
                //         'mimeTypes' => [
                //             'image/jpeg',
                //             'image/png',
                //         ],
                //         'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPEG, PNG)',
                //     ])
                // ],
            ])
            ->add('authors', EntityType::class, [
                'class' => Author::class,
                'choice_label' => function (Author $author) {
                    return $author->getFirstname() . ' ' . $author->getLastname();
                },
                'multiple' => true,
                'expanded' => false,
                'label' => 'Auteur(s) du livre',
                'attr' => [
                    'placeholder' => 'Auteur(s) du livre',
                ],
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Tags',
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Catégories',
            ])
            ->add('languages', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'language',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Langues',
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
