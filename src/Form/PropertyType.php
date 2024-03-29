<?php

namespace App\Form;

use App\Entity\user;
use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            // ->add('slug', TextType::class, [
            //     'attr' => [
            //         'class' => 'form-control'
            //     ]
            // ])
            ->add('price', NumberType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'height: 122px; resize: none;',
                ]
            ])
            ->add('createdAt', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => false,
                'attr' => [
                    'style' => 'display: none;'
                ]
            ])
            ->add('cover', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('nbRoom', NumberType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('checkIn', TimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('checkOut', TimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('zip', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('country', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('user', EntityType::class, [
                'label' => false,
                'class' => User::class,
                'choice_label' => 'id',
                'attr' => [
                    'style' => 'display: none;',
                ],
            ])
            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
            ])
            ->add('publish', SubmitType::class, [
                'attr' => [
                    'class' => 'publish-btn'
                ]
            ])
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            // Définir l'option "user"
            'user' => null, 
        ]);
    }
}
