<?php

namespace App\Service;

class Uri
{

    public function getUrl(){
        $URL = "http://localhost/login";
        return $URL; 

    }
    public function getUrlInvite($jeton){
        $URL = "http://localhost/token/control/".$jeton;
        return $URL; 

    }


}




