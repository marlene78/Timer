<?php

namespace App\Form;


use App\Entity\Project;
use App\Form\GroupType;
use App\Form\TokenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('dateDeDebut' , DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'format' => 'dd/MM/yyyy',
                'input_format' => 'Y-m-d'
            ])
            ->add('DateDeFin' , DateTimeType::class,[
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'format' => 'dd/MM/yyyy',
                'input_format' => 'Y-m-d'
            ])
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
