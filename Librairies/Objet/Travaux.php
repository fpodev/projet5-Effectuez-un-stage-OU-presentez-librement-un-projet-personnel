<?php
/*
Author: fpodev (fpodev@gmx.fr)
Travaux.php (c) 2020
Desc: Objet Travaux
Created:  2020-04-13T14:03:28.788Z
Modified: !date!
*/
namespace App\Objet;

use App\Objet\AbstractClass;

class Travaux extends AbstractObjet
{    
    
    private $id_lieu;
    private $id_batiment;
    private $id_zone;    
    private $id_materiel; 
    private $id_demandeur; //$user mail
    private $id_technicien; //$user niveau 3
    private $description;
    private $detail;
    private $urgence; 
    private $date_demande;
    private $date_prevu;
    private $date_debut;
    private $date_fin;
    private $externe;

    const DESCRIPTION_INVALIDE = 1;
    const DETAIL_INVALIDE = 2;
    const URGENCE_INVALIDE = 3;
    const DATE_PREVU_INVALIDE = 4;
    const DATE_DEBUT_INVALIDE = 5;
    const DATE_FIN_INVALIDE = 6;
    const EXTERNE_INVALIDE = 7;   
 
    public function isValid()
    {
        return !(empty($this->description) 
                || empty($this->id_materiel)
                || empty($this->id_zone)
                || empty($this->id_lieu)
                || empty($this->id_batiment)
                || empty($this->id_demandeur) 
                || empty($this->id_technicien)
                || empty($this->detail) 
                || empty($this->urgence)                
                || empty($this->date_prevu)
                || empty($this->date_debut) 
                || empty($this->date_fin) 
                || empty($this->externe));
    }
    //setter 
    public function setId_Lieu($id_lieu)
    {
        $this->id_lieu = (int) $id_lieu;
    }
    public function setId_batiment($id_batiment)
    {
        $this->id_batiment = (int) $id_batiment;
    }  
    public function setId_Zone($id_zone)
    {
        $this->id_zone = (int) $id_zone;                         
    } 
    public function setId_materiel($id_materiel)
    {
        $this->id_materiel = (int) $id_materiel;
    } 
    public function setId_demandeur($id_demandeur)
    {
        $this->id_demandeur = (int) $id_demandeur;
    }
    public function setId_technicien($id_technicien)
    {
        $this->id_technicien = (int) $id_technicien;
    }
    
    public function setDescription($description)
    {
        if(!is_string($description) || empty($description))
        {
            $this->erreurs[] = self::DESCRIPTION_INVALIDE;
        }
        else
        {
            $this->description = $description;
        }    
    }     
    public function setDetail($detail)
    {
        if(!is_string($detail) || empty($detail))
        {
            $this->erreurs[] = self::DETAIL_INVALIDE;
        }
        else{
            $this->detail = $detail;
        }        
    } 
    public function setUrgence($urgence)    
    {
        if(empty($urgence))
        {
            $this->erreurs[] = self::URGENCE_INVALIDE;
        }
        else{
            $this->urgence = $urgence;
        }        
    } 
    public function setDate_demande($date_demande)
    {
         $this->date_demande = $date_demande;
    }
    public function setDate_prevu($date_prevu)
    {
        if(empty($date_prevu))
        {
            $this->erreurs[] = self::DATE_PREVU_INVALIDE;
        }
        else{
            $this->date_prevu = $date_prevu;
        }
    }  
    public function setDate_debut($date_debut) 
    {
        if(empty($date_debut))
        {
            $this->erreurs[] = self::DATE_DEBUT_INVALIDE;
        }
        else{
            $this->date_debut = $date_debut;
        }
    }  
    public function setDate_fin($date_fin) 
    {
        if(empty($date_fin))
        {
            $this->erreurs[] = self::DATE_FIN_INVALIDE;
        }
        else{
            $this->date_fin = $date_fin;
        }
    }  
    public function setExterne($externe)
    {
        if(empty($externe))
        {
            $this->erreurs[] = self::EXTERNE_INVALIDE;
        }
        else{
            $this->externe = $externe;
        }
    }
    //getter 
    public function getId_lieu()
    {
        return $this->id_lieu;
    }
    public function getId_batiment()
    {
        return $this->id_batiment;
    }  
    public function getId_Zone()
    {
        return $this->id_zone;                         
    } 
    public function getId_materiel()
    {
        return $this->id_materiel;
    } 
    public function getId_demandeur()
    {
        return $this->id_demandeur;
    }
    public function getId_technicien()
    {
        return $this->id_technicien;
    }    
    public function getDescription()
    {        
        return $this->description;          
    }     
    public function getDetail()
    {               
        return $this->detail;             
    } 
    public function getUrgence()    
    {                         
        return $this->urgence;            
    } 
    public function getDate_demande()
    {
        return $this->date_demande;
    }
    public function getDate_prevu()
    {                   
        return $this->date_prevu;        
    }  
    public function getDate_debut() 
    {                           
        return $this->date_debut;        
    }  
    public function getDate_fin() 
    {        
        return $this->date_fin;        
    }  
    public function getExterne()
    {                     
        return $this->externe;
    
    }

}

