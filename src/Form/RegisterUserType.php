<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Adresse email', 'attr' => ['placeHolder' => 'Entrez votre adresse email']
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        'max' => 4049,
                    ]),
                ],
                'first_options' => [
                'label' => 'Mot de passe', 
                'attr' => ['placeHolder' => 'Entrez votre mot de passe'],
                'hash_property_path' => 'password'
                ],
                'second_options' => [
                'label' => 'Confirmer le mot de passe', 
                'attr' => ['placeHolder' => 'Confirmer le mot de passe'],
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas',
                'mapped' => false,
            ])

            ->add('name', TextType::class, [
                'label' => 'Nom', 'attr' => ['placeHolder' => 'Entrez votre nom']
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom', 'attr' => ['placeHolder' => 'Entrez votre prénom']
            ])
            -> add('submit', SubmitType::class,[
                'label' => 'Inscription',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'constraints' => [
                new UniqueEntity([
                    'entityClass' => User::class,
                    'fields' => ['email'],
                ])
                ],
            'data_class' => User::class,
        ]);
    }
}
