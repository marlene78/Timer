<?php

namespace App\Service;

class Progress{
    
    
    /**
     * pourcentage du temps de travail selon le temps estimé
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function progressBar($heure, $mn,$sec, $tempsEstime){
      
         $max = 100;

        //convertir en seconde 
        $heures = $heure * 3600; 
        $minutes = $mn *60;
        $seconds = $sec;
        $tempsEcouleSeconds = $heures + $minutes + $seconds;
        $tempsEstimeSeconds = $tempsEstime * 3600;

        //calcul pourcentage
        $progressBar =  ($tempsEcouleSeconds * $max) / $tempsEstimeSeconds;
         
        return round($progressBar, 1);
     
    
   
 
    }

}