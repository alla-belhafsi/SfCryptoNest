<?php

namespace App\Form;

use App\Entity\user;
use App\Entity\Booking;
use App\Entity\property;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Arrival Date',
                'attr' => [
                    'class' => 'form-control',
                    // 'readonly' => $isAdmin,
                ]
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Departure Date',
                'attr' => [
                    'class' => 'form-control',
                    // 'readonly' => $isAdmin,
                ]
            ])
            // ->add('amount', NumberType::class, [
            //     'label' => false,
            //     'disabled' => true,
            //     'attr' => [
            //         'class' => 'form-control',
            //     ]
            // ])
            // ->add('bookingDate', DateTimeType::class, [
            //     'widget' => 'single_text',
            //     'label' => false,
            //     'attr' => [
            //         // 'class' => 'form-control',
            //         // 'style' => 'display: none;'
            //     ]
            // ])
            // ->add('user', EntityType::class, [
            //     'class' => user::class,
            //     'choice_label' => 'id',
            //     'label' => false,
            //     'attr' => [
            //         // 'style' => 'display: none;',
            //     ],
            // ])
            // ->add('Property', EntityType::class, [
            //     'class' => property::class,
            //     'choice_label' => 'id',
            //     'label' => false,
            //     'attr' => [
            //         // 'style' => 'display: none;',
            //     ],
            // ])
            ->add('Book', SubmitType::class, [
                'attr' => [
                    'class' => 'publish-btn'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'user' => null,
        ]);
    }

    // public function configureOptions(OptionsResolver $resolver): void
    // {
    //     $resolver->setDefaults([
    //         'data_class' => Booking::class,
    //     ]);
    // }
}
