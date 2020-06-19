<?php

namespace App\Controller;



use App\Entity\Task;
use App\Entity\Project;
use App\Service\Progress;
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
    public function index(TaskRepository $repoTask ,Progress $progressBar)
    {
        $projects = $this->getDoctrine()->getRepository(Project::class)->findAll();
        $repoTache = $this->getDoctrine()->getRepository(Task::class)->findAll();
        $TE;
        foreach($repoTache as $tache){
            $TempsEstime = $tache->getTempsEstime();
            $TE = $tache->getTimer();
        }
         
        $TempsEcoule = $progressBar->formatValue(".$TE.") ;
        

        return $this->render('home/index.html.twig' , [
            'user_tache' => $repoTask->findBy([
                'user' => $this->getUser(),
                'cloture' => 0
            ]),
        
            'timeProgresse' => $progressBar->progressBar($TempsEstime, $TempsEcoule),
             
            
            
            
        ]);
    }
}
