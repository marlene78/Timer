<?php

namespace App\Controller;

use App\Service\Uri;
use App\Entity\Message;
use App\Form\MessageType;
use App\Entity\Notification;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\Repository\MessageRepository;
use App\Repository\ProjectRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/user/message")
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/", name="message_index", methods={"GET"})
     */
    public function index(MessageRepository $messageRepository): Response
    {
        return $this->render('message/index.html.twig', [
            'messages' => $messageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="message_new", methods={"POST"})
     */
    public function new(Request $request , ProjectRepository $repoProject , UserRepository $repoUser , TaskRepository $repoTask , Uri $url , MailerInterface $mailer ): Response
    {
        //vérification si projet existe
        $projet = $repoProject->find($request->request->get('id-projet'));
        if(!empty($projet)){

            $manager = $this->getDoctrine()->getManager();

            //récupération de la tâches
            $task = $repoTask->find($request->request->get('id-task')); 

            //création du message
            $message = new Message();
            $message->setContent($request->request->get('message'));
            $message->setUser($this->getUser()); 
            $message->setTask($task);

            $manager->persist($message);

            //Création de la notification 
            $notif = new Notification();
            $notif->setMessage($message->getContent()); 
            $notif->setEmetteur($this->getUser()); 
            $notif->setDestinataire($projet->getCreateur()); 

            $manager->persist($notif);

            $manager->flush(); 


            //ENVOIS EMAIL
        
            $mail = (new TemplatedEmail())
              ->from('ne-pas-repondre@timer.com')
              ->to($projet->getCreateur()->getEmail())
              ->subject("Une nouvelle question")
              ->htmlTemplate("mail/question.html.twig")
              ->context([
                  'message' => "Une demande d'information concernant le projet ". $projet->getNom() ." vous a été transmise.<br>Connectez-vous pour la consulter ! ",
                  'url' => $url->getUrl()
              ]);
              $mailer->send($mail);

              return new JsonResponse( "Votre message a été transmis" , 200); 
    
        }else{
            return new JsonResponse( "Une erreur s'est produite veuillez essayer ultérieurement" , 500); 
        }
  
      
    }

    /**
     * @Route("/{id}", name="message_show", methods={"GET"})
     */
    public function show(Message $message): Response
    {
<<<<<<< HEAD
        
        $update = new Update(
            'http://timer-ipssi.herokuapp.com/user/ping' , 
            json_encode(['data' => 'OutOfStock']),
            true  
        );
        $bus->dispatch($update);
   
        return $this->redirectToRoute("message_project" , [
            'id' => 1
=======
        return $this->render('message/show.html.twig', [
            'message' => $message,
>>>>>>> develop
        ]);
    }

    /**
     * @Route("/{id}/edit", name="message_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Message $message): Response
    {
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('message_index');
        }

        return $this->render('message/edit.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="message_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Message $message): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('message_index');
    }
}
