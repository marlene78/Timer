<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Service\EtatProject;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/user/project")
 */
class ProjectController extends AbstractController
{
    /**
     * Liste des projets
     * @Route("/", name="project_index", methods={"GET"})
     */
    public function index(ProjectRepository $projectRepository, EtatProject $e): Response
    {
        //on determine l'etat du projet
        foreach($projectRepository->findAll() as $projet){
            $dateDeDebut = strtotime($projet->getDateDeDebut()->format('Y-m-d'));
            $dateDeFin = strtotime($projet->getDateDeFin()->format('Y-m-d'));

            $etat = $e->EtatDuProjet($dateDeDebut, $dateDeFin);
            $projet->setEtat($etat);
        }
        return $this->render('project/index.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }
 
    /**
     * Création d'un projet
     * @Route("/new", name="project_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
     
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $project->setCreateur($this->getUser()); 
            $entityManager->persist($project);
            $entityManager->flush();
            $this->addFlash("success" , "Félicitation Projet créer. Ajouter une nouvelle tâche ! "); 

            return $this->redirectToRoute('project_index');
        }

        return $this->render('project/new.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Affichage d'un projet
     * @Route("/{id}", name="project_show", methods={"GET"})
     */
    public function show(Project $project, EtatProject $e ): Response
    {
    
        //Ici on determine l'etat du projet
        $dateDeDebut = strtotime($project->getDateDeDebut()->format('Y-m-d'));
        $dateDeFin = strtotime($project->getDateDeFin()->format('Y-m-d'));
        $etat = $e->EtatDuProjet($dateDeDebut, $dateDeFin);
        $project->setEtat($etat);
        
        
        return $this->render('project/show.html.twig', [
            'project' => $project,
        ]);
    }


    /**
     * Édition d'un projet
     * @Route("/{id}/edit", name="project_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Project $project): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success" , "Projet mis à jour");  
            return $this->redirectToRoute('project_index');
        }

        return $this->render('project/edit.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }


    /**
     * Suppression d'un projet
     * @Route("/{id}", name="project_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Project $project): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->remove($project);
         
            $entityManager->flush();
            $this->addFlash("danger" , "Projet supprimé"); 
        }

        return $this->redirectToRoute('project_index');
    }


    /**
     * Renvois la liste utilisateurs participant au projet
     * @Route("/getUsers" , name="get_users" , methods={"POST"} )
     */
    public function getUsers( Request $request , ProjectRepository $repo)
    {

        return $this->json($repo->find($request->request->get('id')), 200 , [] , ['groups' => 'get:info']); 


    }


    
}
