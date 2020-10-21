<?php

namespace App\Controller;

use App\Service\Uri;
use App\Entity\Token;
use App\Entity\Project;
use App\Form\TokenType;
use App\Service\GenerateToken;
use App\Repository\TokenRepository;
use App\Repository\ProjectRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/token")
 */
class TokenController extends AbstractController
{
    /**
     * @Route("/invites/{id}", name="token_index", methods={"GET"})
     */
    public function index(TokenRepository $tokenRepository,Project $project): Response
    {
        $id = $project->getId();
        return $this->render('token/index.html.twig', [
            'tokens' => $tokenRepository->findBy(array('project' => $id),
            array('createdAt' => 'desc'),
            null,
            0),
            'idProject' => $id
            
        ]);
    }

    /**
     * Permet de verifier le token de l'utilisateur
     * @Route("/control/{token}", name="token_control", methods={"GET"})
     * tokenReceive=> token reçu après avoir cliquer le lien
     */
    public function controlToken(TokenRepository $tokenRepository, Request $request): Response
    {
        $session = new Session();

        $tokenReceive = $request->get('token');
        //On vérifie si le token est present dans la table
        $t = $tokenRepository->findOneBy(array('token' => $tokenReceive));
        if(!empty($t)){
            $id = $t->getId();
            $mail = $t->getEmailInvite();
            $project = $t->getProject();
            $i = 0;
            $tabInfoInvite = array(
                "id" => $id,
                "mail" => $mail ,
                "project" => $project,
        
            );
            foreach($t->getGroupInvite() as $group){
                $tabInfoInvite["ID-group".$i]= $group->getId();
                $i++;
                
            }
            $session->set('invite', $tabInfoInvite );
        }
            
        $invitation = true ;
        if(!empty($tokenReceive) and $t != NULL ){
            return $this->redirectToRoute('user_new');
        }else {
            $invitation = false;
        } 
        return $this->render('token/invitation.html.twig', [
            'invitation' => $invitation
        ]);
    }

    /**
     * Evoie de l'invitation
     * @Route("/new/{id}", name="token_new", methods={"GET","POST"})
     */
    public function new(Request $request, GenerateToken $t, Project $project, MailerInterface $mailer , Uri $url): Response
    {
        $token = new Token();
        $form = $this->createForm(TokenType::class, $token);
        $form->handleRequest($request);
        $id = $project->getId();



        if ($form->isSubmitted() && $form->isValid()) {
            
            $token->setToken($t->generateToken());
            $token->setCReatedAt(new \DateTime());
            $token->setProject($id);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($token);
            $entityManager->flush();

            //Envoi email à l'invité
            $mail = (new TemplatedEmail())
                ->from('ne-pas-repondre@timer.com')
                ->to($token->getEmailInvite())
                ->subject("Timer invitation from ".$project->getCreateur()->getNom()." ". $project->getCreateur()->getPrenom())
                ->htmlTemplate("mail/invite.html.twig")
                ->context([
                    'prenom' => $token->getEmailInvite(),
                    'message' => "</br> ".$project->getCreateur()->getNom()." ". $project->getCreateur()->getPrenom(). " vous a invité à rejoindre le projet "."<b>".$project->getNom()."</b>."." </br> Cliquez sur ce bouton pour accepter l'invitation.</br>",
                    'url' => $url->getUrlInvite($token->getToken()) //url du site
                ]);

            $mailer->send($mail);

            $this->addFlash("success" , "Félicitation votre invitation a bien été envoyé! "); 
            return $this->redirectToRoute('token_index', array('id' => $id));
        }

        return $this->render('token/new.html.twig', [
            'token' => $token,
            'form' => $form->createView(),
            'idProject' => $id
        ]);
    }

}
