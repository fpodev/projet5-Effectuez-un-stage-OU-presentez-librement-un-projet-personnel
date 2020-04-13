<?php
namespace App\Objet;

use App\Objet\AbstractClass;

class Lieu extends AbstractObjet
{    
    private $ville;     

    const VILLE_INVALIDE = 1;
 
    public function isValid()
    {
        return !(empty($this->ville));
    }
    //setter    
    public function setVille($ville)
    {
        if(!is_string($ville) || empty($ville))
        {
            $this->erreurs[] = self::VILLE_INVALIDE;
        }
        else
        {
            $this->ville = $ville;
        }
    }    
    //getter   
    public function ville()
    {
        return $this->ville;
    }  
}

