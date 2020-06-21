<?php

namespace App\Service;

class Progress{
        /**
     * pourcentage du temps de travail selon le temps estimé
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function progressBar($tempsEcoule, $tempsEstime){
      
         $max = 100;
        //nettoie la chaine
            $characterToDelete = array(' ' ,'h', 'mn', 's', '.', '""');
            $tempsEcoule = ".$tempsEcoule." ;
            
    
        foreach($characterToDelete as $findme){
            $position = strpos($tempsEcoule, $findme);
            if($position !== false){
                $tempsEcoule = str_replace($findme, '', $tempsEcoule);
                }
        }
        //on recupere chaque valeur de la chaine tempsEcoule h, mn , s; puis on convertis en entier
        $delimiter = ":";
        $tabtempsEcoule= explode($delimiter,$tempsEcoule ); 
        $heure = intval($tabtempsEcoule[0]);
        $mn = intval($tabtempsEcoule[1]);
        $sec = intval($tabtempsEcoule[2]);

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