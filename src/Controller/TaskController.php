<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Entity\Project;
use App\Form\EditTaskType;
use App\Repository\TaskRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
     * @Route("/new/{id}", name="task_new", methods={"GET","POST"})
     */
    public function new(Request $request , Project $project): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          
            $entityManager = $this->getDoctrine()->getManager();
            $task->setProjet($project); 
            $entityManager->persist($task);
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
     * @Route("/{id}", name="task_show", methods={"GET"})
     */
    public function show(Task $task): Response
    {
        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }

    /**
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
