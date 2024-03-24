<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Feedback;
use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FeedbackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createdAt', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => false,
                'attr' => [
                    'style' => 'display: none;'
                ]
            ])
            ->add('comment', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'height: 122px; resize: none;',
                ]
            ])
            ->add('rating', NumberType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'display: none;',
                ],
                'label_attr' => [
                    'for' => 'rating_input', 
                ],
            ])
            ->add('user', EntityType::class, [
                'label' => false,
                'class' => User::class,
                'choice_label' => 'id',
                'attr' => [
                    'style' => 'display: none;',
                ],
            ])
            ->add('property', EntityType::class, [
                'label' => false,
                'class' => Property::class,
                'choice_label' => 'id',
                'attr' => [
                    'style' => 'display: none;',
                ],
            ])
            ->add('publish', SubmitType::class, [
                'attr' => [
                    'class' => 'msg-btn'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Feedback::class,
            'user' => null, 
        ]);
    }
}
