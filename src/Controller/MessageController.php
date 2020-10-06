<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessageController extends AbstractController
{

    /**
     * Affiche les messages du projet
     * @Route("/user/message/{id}", name="message_project")
     */
    public function index(Project $project)
    {

        return $this->render('message/index.html.twig' , [
            'project' => $project
        ]);
    }



    /**
     * @Route("/user/message/new" , name="message_new")
     */
    public function new(){






    }





}
