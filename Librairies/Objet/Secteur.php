<?php
namespace App\Objet;

use App\Objet\AbstractClass;

class Secteur extends AbstractObjet
{    
    private $secteur;  
    private $id_batiment; 
    private $id_lieu;  

    const SECTEUR_INVALIDE = 1;
 
    public function isValid()
    {
        return !(empty($this->secteur));
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
    public function setSecteur($secteur)
    {
        if(!is_string($secteur) || empty($secteur))
        {
            $this->erreurs[] = self::SECTEUR_INVALIDE;
        }
        else
        {
            $this->secteur = $secteur;
        }
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

    public function secteur()
    {
        return $this->secteur;
    }  
}

