<?php
namespace App\Objet;

use App\Objet\ExtendsObjet;

class Secteur extends ExtendsObjet
{         
    private $id_batiment; 
    private $id_lieu;     
 
    public function isValid()
    {
        return !(empty($this->name) || empty($this->id_lieu) || empty($this->id_batiment));
    }
    //setter 
    public function setId_Batiment($id_batiment)
    {
        $this->id_batiment = (int) $id_batiment;                 
    }
    public function setId_lieu($id_lieu)
    {
        $this->id_lieu = (int) $id_lieu;  
    }    
    //getter 
    public function id_batiment()
    {
        return $this->id_batiment;
    } 
    public function id_lieu()
    {
        return $this->id_lieu;
    }    
}

