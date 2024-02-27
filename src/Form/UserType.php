<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UserType extends AbstractType
{
    private $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isAdmin = $this->authorizationChecker->isGranted('ROLE_ADMIN');
        
        // 1ère Méthode : Vérifie si l'utilisateur a au moins l'un des rôles spécifiés (Traveller, Host)
        // $isUser = array_reduce(['ROLE_USER', 'ROLE_HOST'], fn($result, $role) => $result or $this->authorizationChecker->isGranted($role), false);

        // 2ème Méthode : Vérifie si l'utilisateur a le rôle de traveller ou host
        // $isUser = $this->authorizationChecker->isGranted('ROLE_USER')
        // || $this->authorizationChecker->isGranted('ROLE_HOST');

        $builder
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    // 'readonly' => $isAdmin,
                ]
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    // 'readonly' => $isAdmin,
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    // 'readonly' => $isAdmin,
                ]
            ])
            ->add('username', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    // 'readonly' => $isAdmin,
                ]
            ])
            ->add('birthdate', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                    // 'readonly' => $isAdmin,
                ]
            ])
            // ->add('isVerified')
            ->add('picture', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    // 'readonly' => $isAdmin,
                ]
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    // 'readonly' => $isAdmin,
                ]
            ])
            ->add('zip', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    // 'readonly' => $isAdmin,
                ]
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    // 'readonly' => $isAdmin,
                ]
            ])
            ->add('country', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    // 'readonly' => $isAdmin,
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Administrator' => 'ROLE_ADMIN',
                    'Traveller' => 'ROLE_USER',
                    'Host' => 'ROLE_HOST',
                ],
                'expanded' => true,
                'multiple' => true,
                'disabled' => !$isAdmin,
            ])
            ->add('update', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
