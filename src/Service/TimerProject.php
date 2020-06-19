<?php
namespace App\Service;


class TimerProject{

    public function afficheTime($start, $end){
        date_default_timezone_set('Europe/Paris');
        $debut = strtotime($start);
        $fin = strtotime($end);
        $diff = $fin - $debut;

        return diff;


/*         ;
        $debut = strtotime($this->dateDeDebut->format('Y/m/d'));
        $fin = strtotime($this->DateDeFin->format('Y/m/d'));
        $diff = $fin - $debut;

        $heures = $diff / 3600;
        $jour = $heures /24;
        //si le temps restant est 1jour on convertis en heure
         if($jour == 0){
            $heure = 24;
            $resultat = $heure - date('h');

            return $resultat. ' h';

        }
        else{ 
            return $jour.' j';
        } */

        
    }
}