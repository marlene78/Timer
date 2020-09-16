<?php

namespace App\Service;

class EtatProject{
    
    
    /**
     * On determine l'etat du projet
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function EtatDuProjet($dateDeDebut, $dateDeFin  ){

        $dateDuJour = strtotime(date("d-m-Y"));
        $etat = "";
        //Traitement du cas ou le projet n'a pas encore démaré.
        if($dateDuJour < $dateDeDebut){
            $etat = "Non commencé"; 
        }
        
        //Traitement du cas ou le projet à démarer
        elseif($dateDuJour >= $dateDeDebut and $dateDuJour < $dateDeFin ){
            $etat = "En traitement";
        }

        else{
            $etat = "Terminé";
        }

        return $etat;
     
    
   
 
    }

}


