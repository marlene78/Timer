<?php

namespace App\Form;


use App\Entity\ChangePassword;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('ancienPassword' , PasswordType::class , [
                'label' => 'Saisissez votre ancien mot de passe', 
                'attr' =>  [
                    'placeholder' =>' Ancien mot de passe'
                ]
            ])
            
            ->add('nouveauPassword' , PasswordType::class , [
                'label' => 'Saisissez votre nouveau mot de passe', 
                'attr' =>  [
                    'placeholder' =>'Nouveau mot de passe'
                ]
            ])

            ->add('confirmPassword' , PasswordType::class , [
                'label' => 'Confirmez votre nouveau mot de passe', 
                'attr' =>  [
                    'placeholder' =>'Nouveau mot de passe'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChangePassword::class,
        ]);
    }
}
