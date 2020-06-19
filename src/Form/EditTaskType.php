<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;



use App\Entity\Project;
use App\Repository\UserRepository;
use App\Repository\ProjectRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class EditTaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       
    
        $builder
       
            ->add('nom')
            ->add('priorite',ChoiceType::class,[
                'choices' => [
                    "Normale"=>"Normale",
                    "Maximale"=>"Maximale",
                    "Elevé"=>"Elevé",
                ]
            ])
            ->add('tempsEstime', null,[
                "label"=>"Temps estimé en heure"
            ])  
            ->add('user' , EntityType::class,[
                'class' => User::class,
                'query_builder' => function (UserRepository $u) {
                    $tab_url = explode("/", $_SERVER['REQUEST_URI']); 
                    return $u->createQueryBuilder('u')
                    ->leftJoin('u.groups' , 'g' )
                    ->leftJoin('g.project' , 'p')
                    ->where('p.id =:val')
                    ->setParameter('val', $tab_url[4])
                  
                    ;
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
