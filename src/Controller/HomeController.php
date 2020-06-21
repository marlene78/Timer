<?php

namespace App\Controller;



use App\Entity\Task;
use App\Entity\Timer;
use App\Entity\Project;
use App\Repository\TaskRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @IsGranted("ROLE_USER")
     */
    public function index(TaskRepository $repoTask)
    {
        //$projects = $this->getDoctrine()->getRepository(Project::class)->findAll();
      

        return $this->render('home/index.html.twig' , [
            'user_tache' => $repoTask->findBy([
                'user' => $this->getUser(),
                'cloture' => 0
            ]),
        
             
            
            
             
        ]);
    }
}
