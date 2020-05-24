<?php
namespace App\Objet;
/*
Author: fpodev (fpodev@gmx.fr)
Secteur.php (c) 2020
Desc: Objet secteur
Created:  2020-04-13T14:03:28.788Z
Modified: !date!
*/
use App\Objet\ExtendsObjet;

class Secteur extends ExtendsObjet
{         
    private $id_batiment; 
    private $id_lieu;     
 
    public function isValid()
    {
        return !(empty($this->nom) ||  empty($this->id_batiment));
    }
    public function isValidUpdate()
    {
        return !(empty($this->nom));
    }
    //setter 
    public function setId_Batiment($id_batiment)
    {
        $this->id_batiment = (int) $id_batiment;                 
    }   
    //getter 
    public function id_batiment()
    {
        return $this->id_batiment;
    }    
}

