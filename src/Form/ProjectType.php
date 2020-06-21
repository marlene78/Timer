<?php

namespace App\Form;


use App\Entity\Project;
use App\Form\GroupType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('dateDeDebut')
            ->add('DateDeFin')
            ->add('description')
            ->add('groups' , CollectionType::class , [
                'entry_type' => GroupType::class, 
                'allow_add' => true,
                'by_reference' => false,
                'required' => false,
                'label' => 'Groupe de travail'
            ])
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
