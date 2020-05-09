<?php
/*
Author: fpodev (fpodev@gmx.fr)
Travaux.php (c) 2020
Desc: Objet Travaux
Created:  2020-04-13T14:03:28.788Z
Modified: !date!
*/
namespace App\Objet;


use App\Objet\ExtendsObjet;
use DateTime;

class Travaux extends ExtendsObjet
{        
    private $id_lieu,
            $id_batiment,
            $id_secteur,    
            $id_materiel,
            $id_demandeur, //$user mail
            $id_technicien, //$user niveau 3
            $descriptions,
            $detail,
            $urgence, 
            $date_demande,
            $date_prevu,
            $date_debut,
            $date_fin,
            $externe;

    const DESCRIPTION_INVALIDE = 2,
          DETAIL_INVALIDE = 3,
          URGENCE_INVALIDE = 4;          
 
   /* public function isValid()
    {                                        
                return                                      
    }*/
    public function validDemande()
    {
        return !(empty($this->descriptions) 
                || empty($this->id_lieu)
                || empty($this->id_secteur) 
                || empty($this->id_materiel)                
                || empty($this->id_batiment)
                || empty($this->id_demandeur)
                || empty($this->detail)            
                || empty($this->urgence));
    }
    public function validPlanif()
    {
        return !(empty($this->date_prevu) 
                || empty($this->descriptions)            
                || empty($this->detail) 
                || empty($this->id_technicien) 
                || empty($this->externe));
    }
    public function validStart()
    {
        return !(empty($this->date_debut)) ;                      
    }
    public function validClose()
    {
        return !(empty($this->date_fin));
    }
    public function setId_Lieu($id_lieu)
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
    public function setId_materiel($id_materiel)
    {
        $this->id_materiel = (int)$id_materiel;
    } 
    public function setId_demandeur($id_demandeur)
    {
        $this->id_demandeur = (int)$id_demandeur;
    }
    public function setId_technicien($id_technicien)
    {
        $this->id_technicien = (int)$id_technicien;
    }    
    public function setDescriptions($descriptions)
    {
        if(!is_string($descriptions) || empty($descriptions))
        {
            $this->erreurs[] = self::DESCRIPTION_INVALIDE;
        }
        else
        {
            $this->descriptions = $descriptions;
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
       $this->date_prevu = $date_prevu;        
    }  
    public function setDate_debut($date_debut) 
    {                           
            $this->date_debut = $date_debut;       
    }  
    public function setDate_fin($date_fin) 
    {                           
            $this->date_fin = $date_fin;      
    }  
    public function setExterne($externe)
    {                  
            $this->externe = $externe;      
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
    public function id_materiel()
    {
        return $this->id_materiel;
    } 
    public function id_demandeur()
    {
        return $this->id_demandeur;
    }
    public function id_technicien()
    {
        return $this->id_technicien;
    }    
    public function descriptions()
    {        
        return $this->descriptions;          
    }     
    public function detail()
    {               
        return $this->detail;             
    } 
    public function urgence()    
    {                         
        return $this->urgence;            
    } 
    public function date_demande()
    {
        return $this->date_demande;
    }
    public function date_prevu()
    {                   
        return $this->date_prevu;        
    }  
    public function date_debut() 
    {                           
        return $this->date_debut;        
    }  
    public function date_fin() 
    {        
        return $this->date_fin;        
    }  
    public function externe()
    {                     
        return $this->externe;
    
    }

}

