<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\Token;
use App\Repository\GroupRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TokenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('groupInvite' , EntityType::class , [
                'label' => 'Groupe',
                'class' => Group::class, 
                'multiple' => true,
                'query_builder' => function (GroupRepository $g) {
                    $tab_url = explode("/", $_SERVER['REQUEST_URI']);
                    return $g->createQueryBuilder('g')
                    ->where('g.project =:val')
                    ->setParameter('val', $tab_url[3]);
        
                    ;
                }
                
            ])
            ->add('emailInvite',TextType::class,array(
                'label' => ' ',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Ajouter un adresse e-mail'
                )
            ))
            
        ;
 
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Token::class,
        ]);
    }
}
