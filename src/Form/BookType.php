<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->add('price', MoneyType::class, [])
            
            ->add('cover', FileType::class, [
                'required' => false,
            ])

            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])

            ->add('authors', CollectionType::class, [
                'entry_type' => EntityType::class,
                'entry_options' => [
                    'class' => Author::class,
                    'choice_label' => 'fullname'
                ],
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('someTest', ChoiceType::class, [
                'mapped' => false,
                'choices'  => [
                    'Maybe' => 'null',
                    'Yes' => 'true',
                    'No' => 'false',
                ],
                'multiple' => false,
                'expanded' => false
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
