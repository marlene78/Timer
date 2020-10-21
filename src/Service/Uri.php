<?php

namespace App\Service;

class Uri
{

    public function getUrl(){
        $URL = "http://timer-ipssi.herokuapp.com/";
        return $URL; 

    }
    public function getUrlInvite($jeton){
        $URL = "http://timer-ipssi.herokuapp.com/token/control/".$jeton;
        return $URL; 

    }


}




