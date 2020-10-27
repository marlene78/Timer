<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Project;
use App\Repository\MessageRepository;
use App\Repository\ProjectRepository;
use Symfony\Component\Mercure\Update;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MessageController extends AbstractController
{

    /**
     * Page d'accueil tchat d'un projet
     * @Route("/user/message/{id}", name="message_project")
     */
    public function index(Project $project)
    {
        //vérification si l'utilisateur connecté est autorisé accéder au tchat
        $erreur = "Accès non autorisé" ;  
       foreach($project->getGroups() as $groupe){
           foreach($groupe->getUsers() as $user){
                $user->getNom() === $this->getUser()->getNom() ? $erreur = null :"" ; 
            }     
        }

        return $this->render('message/index.html.twig' , [
            'project' => $project, 
            "erreur" => $erreur != null
        ]);
    }



    /**
     * Ajout d'un message dans le tchat
     * @Route("/user/message-new/" , name="message_new" , methods={"POST"})
     */
    public function new(Request $request , ProjectRepository $repo )
    {

        $project = $repo->find($request->request->get('projet_id')); 
        if($project){
           
            /*//Distribution asynchrone du message
           function ping(MessageBusInterface $bus){

                $update = new Update(
                    'http://localhost/user/message/1' , 
                    json_encode(['data' => 'OutOfStock']),
                    true  
                );
                $bus->dispatch($update);
            }
            */
           
            $message = new Message();

            $message->setContent($request->request->get('message-to-send')); 
            $message->setProject($project); 
            $message->setUser($this->getUser()); 
    
            $em = $this->getDoctrine()->getManager(); 
            $em->persist($message);
            $em->flush(); 

            return new Response('ok');

        }else{
            return new Response("Impossible d'envoyer votre message." , 500); 
        }



    }




    /**
     * @Route("/user/new_ping" , name="new_ping" ,  methods={"POST"})
     */
    public function ping(MessageBusInterface $bus , Request $request):Response
    {
        
        
        $update = new Update(
            'http://localhost/user/ping' , 
            json_encode(['data' => 'OutOfStock']) 
        );
        $bus->dispatch($update);
   
        return $this->redirectToRoute("message_project" , [
            'id' => 1
        ]);
      
    }




    /**
     * Affiche les messages du projet
     * @Route("/user/project/get/message" , name="project_get_messages" , methods={"GET"})
     */
    public function getMessages(MessageRepository $repo , Request $request){

        return $this->json($repo->findBy(["project" => $request->get('id') ]) , 200 , [] , ['groups' => 'get:info']); 
    }




    

    /**
     * Supprimer un message
     * @Route("/user/message/delete/{id}" , name="message_delete" , methods={"DELETE"} )
     */
    public function delete(Message $message)
    {
        //vérification de l'user 
        $user = $message->getUser(); 
        if($user == $this->getUser()){
            $em = $this->getDoctrine()->getManager();
            $em->remove($message); 
            $em->flush(); 
            return new Response("Message supprimé" , 200); 

        }else{
            return new Response("Une erreur s'est produite" , 500); 
        }

    }



}
