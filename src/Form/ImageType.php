<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Image URL"
                ]
            ])
            ->add('caption', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Image caption"
                ]
            ])
            ->add('property', EntityType::class, [
                'class' => property::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
