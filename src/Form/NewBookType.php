<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Language;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;


class NewBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->add('price', MoneyType::class, [])
            

            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])

            ->add('language', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'lang',
                'mapped' => false,
                'preferred_choices' => ['lang' => 'fr'],
            ])

            ->add('authors', CollectionType::class, [
                'entry_type' => EntityType::class,
                'entry_options' => [
                    'class' => Author::class,
                    'choice_label' => 'fullname',
                    'placeholder' => 'Please select a language first',
                    'choices' => []
                ],
                'allow_add' => true,
                'allow_delete' => true,
            ])

            ->add('submit', SubmitType::class)
        ;

        $formModifier = function (FormInterface $form, Language $language = null) {
            $authors = null === $language ? [] : $language->getAuthors();

            $form->add('authors', CollectionType::class, [
                    'entry_type' => EntityType::class,
                    'entry_options' => [
                        'class' => Author::class,
                        'choice_label' => 'fullname',
                        'placeholder' => 'Select the author',
                        'choices' => $authors
                    ],
                    'allow_add' => true,
                    'allow_delete' => false,
                ]);
        };

        $builder->get('language')
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($formModifier) {
                $formModifier($event->getForm()->getParent(), $event->getForm()->getData());
            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
