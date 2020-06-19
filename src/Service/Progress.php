<?php
namespace App\Service;


class Progress{
    
    const MAX = 100;


    /**
     * @name convertToSecond()
     * @param int $h, $m, $s 
     * @return int la somme des secondes calculée à partir des paramétres 
     */
    public function convertToSecond($h, $m, $s){
        
        $heures = $h * 3600; 
        $minutes = $m *60;
        $seconds = $s;

        $tempsEnSeconds = $heures + $minutes + $seconds;

        return $tempsEnSeconds;

    }

    /**
     * @name progressBar()
     * @param  int $tempsEstime, $tempsEcoule
     * @return  int pourcentage du temps de travail selon le temps estimé
     *  on delimite la chaine pour récuperer le tableau
     *  on recupere chaque valeur de la chaine tempsEcoule h, mn , s; puis on convertis en entier
     *  on convertis en seconde
     * calcul du pourcentage
     */
    public function progressBar($tempsEstime, $tempsEcoule){

        $delimiter = ":";
        $tabtempsEcoule= explode($delimiter,$tempsEcoule );
         
        $heure = intval($tabtempsEcoule[0]);
        $mn = intval($tabtempsEcoule[1]);
        $sec = intval($tabtempsEcoule[2]);
        
        $tempsEcouleSeconds = $this->convertToSecond($heure, $mn, $sec);
        $tempsEstimeSeconds = $tempsEstime * 60;

        
        $progressBar =  ($tempsEcouleSeconds * self::MAX) / $tempsEstimeSeconds;

        return round($progressBar, 1);
    }

    /**
     * @name formatValue()
     * @param  string chaine
     * @return  string chaine nettoie les characterToDelete de la chaine fournie en paramétre
     * 
     */
    public function formatValue($chaine){
        
        
        $characterToDelete = array(' ' ,'h', 'mn', 's', '.', '""');
        $chaine = ".$chaine." ;

        foreach($characterToDelete as $findme){
            $position = strpos($chaine, $findme);
            if($position !== false){
                $chaine = str_replace($findme, '', $chaine);
            }
        }
        return $chaine;
    }
}