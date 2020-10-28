<?php

namespace App\Controller;

use App\Entity\Task;
use App\Service\Uri;
use App\Entity\Timer;
use App\Form\TaskType;
use App\Entity\Project;
use App\Service\Progress;
use App\Form\EditTaskType;
use App\Repository\TaskRepository;
use App\Repository\TimerRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/user/task")
 */
class TaskController extends AbstractController
{
    /**
     * Liste des tâches du projet
     * @Route("/liste/{id}", name="task_index", methods={"GET"})
     */
    public function index(TaskRepository $taskRepository , Project $projet): Response
    {
        return $this->render('task/index.html.twig', [
            'tasks' => $taskRepository->findBy([
                'projet' => $projet->getId()
            ]),
            'projet' => $projet
        ]);
    }



    /**
     * Création d'une tâche pour un projet 
     * Initialisation du timer 
     * @Route("/new/{id}", name="task_new", methods={"GET","POST"})
     */
    public function new(Request $request , Project $project ,  MailerInterface $mailer , Uri $url): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
          
            $entityManager = $this->getDoctrine()->getManager();
            $task->setProjet($project); 

            //initalisation du timer 
            $timer = new Timer();
            $timer->setprogress(0); 
            $timer->setHeure(0); 
            $timer->setMinute(0); 
            $timer->setSeconde(0); 
            $timer->setTask($task);
            
            
            //Envoi email à l'utilisateur
            $mail = (new TemplatedEmail())
            ->from('ne-pas-repondre@timer.com')
            ->to($task->getUser()->getEmail())
            ->subject("Une nouvelle tâche")
            ->htmlTemplate("mail/index.html.twig")
            ->context([
                'prenom' => $task->getUser()->getPrenom(),
                'message' => "Une nouvelle tâche vient de vous être attribué(e).<br> Connectez-vous pour la consulter ! ",
                'url' => $url->getUrl() 
            ]);
            $mailer->send($mail);

            $entityManager->persist($task);
            $entityManager->persist($timer);
            $entityManager->flush();

            $this->addFlash("success" , "Tâche ajoutée"); 

            return $this->redirectToRoute('task_index' , [
                'id' => $project->getId()
            ]);
        }

  
        return $this->render('task/new.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
            'projet' => $project, 
        ]);
    }



    /**
     * Affichage d'une tâche
     * @Route("/show/{id}", name="task_show", methods={"GET","POST"})
     */
    public function show(Task $task, Request $request): Response
    {
        $repoTache = $this->getDoctrine()->getRepository(Task::class)->findAll();

      
        return $this->render('task/show.html.twig', [
            'task' => $task,
            
        ]);
    }


    /**
     * Enregistrement du temps écouler
     * Calcule du temps de progression
     * @Route("/set/timer/{id}", name="task_set_time", methods={"GET"})
     */
    public function setTimer(Request $request, Timer $timer , Progress $p): Response
    {
       
        if($timer != null){

            $entityManager = $this->getDoctrine()->getManager();
            $timer->setHeure($request->query->get('heure'));
            $timer->setMinute($request->query->get('minute'));
            $timer->setSeconde($request->query->get('seconde'));
            $timer->getTask()->getDemarre() == 0 ?  $timer->getTask()->setDemarre(1) : "" ; //tâche démarrer

            //enregistrement du temps 
            $tempsProgress = $p->progressBar($request->query->get('heure'),$request->query->get('minute'), $request->query->get('seconde') , $timer->getTask()->getTempsEstime()); 
            $timer->setprogress($tempsProgress); 
            $tempsProgress == 100 ? $timer->getTask()->setCloture(1) : ""; 

            $entityManager->flush(); 
            return new JsonResponse("Tâche démarré", 200);

        }else{
            return new JsonResponse("Impossible de démarrer la tâche, veuillez essayer ultérieurement", 500);
        }
        
           
    }



    /**
    * Récupération de la valeur du timer
    * @Route("/getTime_task/{id}", name="task_get_time", methods={"POST"})
    */
    public function getTimer(Request $request, Timer $timer): Response
    {
        $info = [
            'heure' => $timer->getHeure(), 
            'minute' => $timer->getMinute(), 
            'seconde' => $timer->getSeconde()
        ]; 
       return new JsonResponse($info , 200); 
        
    }



    /**
     * Édition d'une tâche
     * @Route("/edit/{projet}/{id}", name="task_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Task $task): Response
    {
        $form = $this->createForm(EditTaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success" , "Mise à jour réussite"); 

            return $this->redirectToRoute('project_show' , [
                'id' => $task->getProjet()->getId()
            ]);
        }

        return $this->render('task/edit.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
        ]);
    }



    /**
     * Suppression d'une tâche
     * @Route("/{id}", name="task_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Task $task): Response
    {
        if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($task);
            $entityManager->flush();

            $this->addFlash("danger" , "Tâche supprimé"); 
        }

        return $this->redirectToRoute('task_index');
    }
}