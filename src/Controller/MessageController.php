<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Project;
use App\Repository\MessageRepository;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
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
     * Création d'un message
     * @Route("/user/message-new/" , name="message_new" , methods={"POST"})
     */
    public function new(Request $request , ProjectRepository $repo):Response
    {

        $project = $repo->find($request->request->get('projet_id')); 
        if($project){
            $message = new Message();


            $message->setContent($request->request->get('message-to-send')); 
            $message->setProject($project); 
            $message->setUser($this->getUser()); 
    
            $em = $this->getDoctrine()->getManager(); 
            $em->persist($message);
            $em->flush(); 
    
            return new Response("ok"); 
        }else{
            return new Response("Impossible d'envoyer votre message."); 
        }



    }




    /**
     * @Route("/user/project/get/message" , name="project_get_messages" , methods={"GET"})
     */
    public function getMessages(MessageRepository $repo , Request $request){

        return $this->json($repo->findBy(["project" => $request->get('id') ]) , 200 , [] , ['groups' => 'get:info']); 
    }



}
