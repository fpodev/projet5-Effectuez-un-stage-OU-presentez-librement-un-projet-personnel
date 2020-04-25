<?php
namespace App\Objet;

use App\Objet\ExtendsObjet;
class Batiment extends ExtendsObjet
{    
    
    private $id_lieu;   

    const NAME_INVALIDE = 1;
 
    public function isValid()
    {
        return !(empty($this->name) || empty($this->id_lieu));
    }
    //setter 
    public function setId_lieu($id_lieu){
        $this->id_lieu = (int) $id_lieu;                 
    }    
    //getter 
    public function id_lieu()
    {
        return $this->id_lieu;
    }      
}

