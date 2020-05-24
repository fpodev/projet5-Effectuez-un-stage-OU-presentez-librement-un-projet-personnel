<?php
namespace App\Objet;
/*
Author: fpodev (fpodev@gmx.fr)
Materiel.php (c) 2020
Desc: Objet materiel
Created:  2020-04-13T14:03:28.788Z
Modified: !date!
*/
use App\Objet\ExtendsObjet;
class Materiel extends ExtendsObjet
{         
    private $id_secteur; 
    
    
     public function isValid()
    {
        return !(empty($this->nom) || empty($this->id_secteur));
    }
    public function isValidUpdate()
    {
        return !(empty($this->nom));
    }
    //setter     
    public function setId_secteur($id_secteur)
    {
        $this->id_secteur = (int)$id_secteur;                 
    }  
    //getter      
    public function id_secteur()
    {
        return $this->id_secteur;
    }      
}

