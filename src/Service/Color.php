<?php

namespace App\Service;

class Color{


    function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }
    
    public function generateRandomColor() {
        return "#".$this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }
    
    

}