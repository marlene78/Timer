<?php

namespace App\Service;

class GenerateToken{

    //Génération aléatoire d'un token
    public function generateToken(){
     
    $token = openssl_random_pseudo_bytes(16);
    $token = bin2hex($token);
    
    return $token;
    }



}
    