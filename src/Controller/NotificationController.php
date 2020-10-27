<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Form\NotificationType;
use App\Repository\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/notification")
 */
class NotificationController extends AbstractController
{

    /**
     * Liste des notifications d'un utilisateur
     * @Route("/", name="notification_index", methods={"GET"})
     */
    public function index(NotificationRepository $notificationRepository): Response
    {
        return $this->render('notification/index.html.twig', [
            'notifications' => $notificationRepository->findBy([
                'destinataire' => $this->getUser()
            ]),
        ]);
    }




    /**
     * Visualisation d'une notification
     * @Route("/{id}", name="notification_show", methods={"GET"})
     */
    public function show(Notification $notification): Response
    {
        if($notification->getLu() == 0){
            $notification->setLu(1); 
            $this->getDoctrine()->getManager()->flush(); 
        }

        return $this->render('notification/show.html.twig', [
            'notification' => $notification,
        ]);
    }



    /**
     * Suppression d'une notification
     * @Route("/{id}", name="notification_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Notification $notification): Response
    {
        if ($this->isCsrfTokenValid('delete'.$notification->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($notification);
            $entityManager->flush();
        }

        return $this->redirectToRoute('notification_index');
    }
}
