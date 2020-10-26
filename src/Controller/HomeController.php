<?php

namespace App\Controller;



use App\Entity\Task;
use App\Entity\Timer;
use App\Entity\Project;


use App\Repository\TaskRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_USER")
 */
class HomeController extends AbstractController
{

    
    /**
     * @Route("/", name="home")
     */
    public function index(TaskRepository $repoTask)
    {
      
        return $this->render('home/index.html.twig' , [
            'user_tache' => $repoTask->findBy([
                'user' => $this->getUser(),
                'cloture' => 0
            ]),
     
        ]);
    }


    
    /**
     * @Route("/documentation", name="aide")
     * 
     */
    public function documentation()
    {
      
        return $this->render('documentation/index.html.twig' , [
            'user_tache' => "coucou"
     
        ]);
    }
}
