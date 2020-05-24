<?php
namespace App\Objet;
/*
Author: fpodev (fpodev@gmx.fr)
Batiment.php (c) 2020
Desc: Objet batiment.
Created:  2020-04-13T14:03:28.788Z
Modified: !date!
*/
use App\Objet\ExtendsObjet;
class Batiment extends ExtendsObjet
{    
    
    private $id_lieu;     
 
    public function isValid()
    {
        return !(empty($this->nom) || empty($this->id_lieu));
    }
    public function isValidUpdate()
    {
        return !(empty($this->nom));
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

