<?php

namespace App\Service;

use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class ConfigEmail
{


    private $adresseMail;
    private $msg;
    private $sujet;
    private $prenom;

    public function __construct($adresseMail, $prenom , $sujet ,$msg)
    {
        $this->adresseMail = $adresseMail;
        $this->msg = $msg;
        $this->sujet = $sujet;
        $this->prenom = $prenom;
 
    }

    public function sendMail(){

        $mail = (new TemplatedEmail())
        ->from('ne-pas-repondre@timer.com')
        ->to($this->adresseMail)
        ->subject($this->sujet)
        ->htmlTemplate("mail/index.html.twig")
        ->context([
            'prenom' => $this->prenom,
            'message' => $this->msg,
            'url' =>"http://localhost/login" //url du site
        ]);
        
        return $mail;

    }



}