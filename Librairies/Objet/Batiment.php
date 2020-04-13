<?php
namespace App\Objet;

use App\Objet\AbstractClass;

class Batiment extends AbstractObjet
{    
    private $batiment;  
    private $id_lieu;   

    const BATIMENT_INVALIDE = 1;
 
    public function isValid()
    {
        return !(empty($this->batiment) || empty($this->id_lieu));
    }
    //setter 
    public function setId_lieu($id_lieu){
        $this->id_lieu = (int) $id_lieu;                 
    }
    public function setBatiment($batiment)
    {
        if(!is_string($batiment) || empty($batiment))
        {
            $this->erreurs[] = self::BATIMENT_INVALIDE;
        }
        else
        {
            $this->batiment = $batiment;
        }
    }    
    //getter 
    public function id_lieu()
    {
        return $this->id_lieu;
    }  
    public function batiment()
    {
        return $this->batiment;
    }  
}

