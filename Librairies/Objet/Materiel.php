<?php
namespace App\Objet;

use App\Objet\ExtendsObjet;
class Materiel extends ExtendsObjet
{         
    private $id_secteur; 
    private $id_batiment;
    private $id_lieu;    
 
    public function isValid()
    {
        return !(empty($this->name) || empty($this->id_secteur) || empty($this->id_batiment) || empty($this->id_lieu));
    }
    //setter 
    public function setId_lieu($id_lieu)
    {
        $this->id_lieu = (int)$id_lieu;
    }
    public function setId_batiment($id_batiment)
    {
        $this->id_batiment = (int)$id_batiment;
    }
    public function setId_secteur($id_secteur)
    {
        $this->id_secteur = (int)$id_secteur;                 
    }  
    //getter 
    public function id_lieu()
    {
        return $this->id_lieu;
    }
    public function id_batiment()
    {
        return $this->id_batiment;
    }
    public function id_secteur()
    {
        return $this->id_secteur;
    }      
}

