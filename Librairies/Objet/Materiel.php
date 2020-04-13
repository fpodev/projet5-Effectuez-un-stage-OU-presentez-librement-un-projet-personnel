<?php
namespace App\Objet;

use App\Objet\AbstractClass;

class Materiel extends AbstractObjet
{    
    private $materiel;  
    private $id_secteur; 
    private $id_batiment;
    private $id_lieu;

    const MATERIEL_INVALIDE = 1;
 
    public function isValid()
    {
        return !(empty($this->materiel) || empty($this->id_zone));
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
    public function setMateriel($materiel)
    {
        if(!is_string($materiel) || empty($materiel))
        {
            $this->erreurs[] = self::MATERIEL_INVALIDE;
        }
        else
        {
            $this->materiel = $materiel;
        }
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
    public function materiel()
    {
        return $this->materiel;
    }  
}

