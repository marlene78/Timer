<?php

namespace App\Controller;

use App\Repository\NotificationRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PartialController extends AbstractController
{
   



    /**
     * Affiche toutes les notifications
     */
    public function notification(NotificationRepository $repoNotif)
    {
        $notifNonLu = $repoNotif->findBy([
            "destinataire" => $this->getUser(), 
            'lu' => 0
        ]); 

        return $this->render('partial/notification.html.twig', [
            'notifNonLu' => $notifNonLu
        ]);

    }
}