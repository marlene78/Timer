<?php

namespace App\Controller;


use App\Entity\User;
use App\Entity\Project;
use App\Repository\UserRepository;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/user/")
 */
class StatistiqueController extends AbstractController
{
    /**
     * @Route("statistique/projet/{id}", name="statistique_projet")
     */
    public function projetStatistique(Project $project)
    {
        return $this->render('statistique/projet.html.twig' , [
            'project' => $project
        ]);
    }


    /**
    * @Route("info/projet/{id}", name="info_projet" , methods={"POST"})
    */
    public function getInfoProject(ProjectRepository $repo , Project $project , Request $request)
    {
        return $this->json($repo->find($request->request->get('id')), 200 , [] , ['groups' => 'get:info']); 

    }


    /**
     * @Route("statistique/user/{id}", name="statistique_user")
     */
    public function taskStatistique(User $user)
    { 
        return $this->render('statistique/user.html.twig' , [
            'user' => $user
        ]);
    }



    /**
    * @Route("info/user/{id}", name="info_user" , methods={"POST"})
    */
    public function getInfoUser(UserRepository $repo , User $user , Request $request)
    {
        return $this->json($repo->find($request->request->get('id')), 200 , [] , ['groups' => 'get:user']); 

    } 



}
