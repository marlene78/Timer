<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\ConfigEmail;
use App\Form\EditionUserType;
use App\Entity\ChangePassword;
use App\Form\ChangePasswordType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class UserController extends AbstractController
{
   

    /**
     * Inscription d'un utilisateur
     * @Route("/inscription", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request ,  UserPasswordEncoderInterface $passwordEncoder ,  MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        $erreur = null; 

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();


            //Encodage du mot de passe
            if($user->getConfirmPassword() == $user->getPassword()){
            
                $hash = $passwordEncoder->encodePassword($user , $user->getPassword());
                $user->setPassword($hash); 

                $confirmHash = $passwordEncoder->encodePassword($user , $user->getConfirmPassword()); 
                $user->setConfirmPassword($confirmHash); 

                $entityManager->persist($user);
                $entityManager->flush();

                //ENVOIS EMAIL
                $configEmail = new ConfigEmail($user->getEmail() , $user->getPrenom() , "Votre compte a été créé" , "votre compte vient d'être créé, connectez-vous pour y accéder ! " );
                $mailer->send($configEmail->sendMail());
                     

                //connexion de l'utilisateur , activation de la session
                $token = new UsernamePasswordToken(
                    $user,
                    $hash,
                    'main',
                    $user->getRoles()
                );

                $this->get('security.token_storage')->setToken($token);
                $this->get('session')->set('_security_main', serialize($token));

                $this->addFlash("success" , "Félicitation ". $user->getPrenom() ." votre compte a été créé");


                return $this->redirectToRoute('home');
    
            }else{
                $erreur = "Les deux mots de passe ne sont pas identiques"; 
            }

        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'erreur' => $erreur
        ]);
    }



    /**
     * Compte utilisateur accéssible si connecté
     * @Route("/user/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * Édition de ses informations
     * @Route("/user/edit/{id}", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(EditionUserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success" , "Félicition mise à jour réussite"); 

            return $this->redirectToRoute('home');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }



    /**
     * Suppression de son compte
     * @Route("/user/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();

            //suppression de la session
            $this->get('security.token_storage')->setToken(null);
            $request->getSession()->invalidate();

            $this->addFlash("danger" , "Votre compte a été supprimé"); 
        }
        return $this->redirectToRoute('login');
    }




    /** 
     * Changement du mot de passe
     * @Route("/user/password/{id}" , name="change_password" , methods={"GET"})
     * 
     */
    public function changePassword( User $user, Request $request , UserPasswordEncoderInterface $passwordEncoder): Response
    {   


        $changePassword = new ChangePassword();

        $form = $this->createForm(ChangePasswordType::class, $changePassword);
        $form->handleRequest($request);


        $erreur = null ; 
          

        if ($form->isSubmitted() && $form->isValid()) {

            $ancienPassword = $changePassword->getAncienPassword(); 

    
            $verif = \password_verify($ancienPassword , $user->getPassword()); 

        
    
            if($verif == true){


                $newPassword = $changePassword->getNouveauPassword();
           
                $hash = $passwordEncoder->encodePassword($user , $newPassword);
                $user->setPassword($hash); 

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success' , 'Mot de passe modifié'); 

                return $this->redirectToRoute('user_show' , [
                    'id' => $user->getId()
                ]);

            
        
            }else{

                $erreur = "Veuillez saisir votre ancien mot de passe"; 
            }
            
 

        }

        return $this->render('user/password.html.twig', [
            'form' => $form->createView(),
            'erreur' => $erreur 
        ]);
        
    }




}
