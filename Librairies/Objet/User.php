<?php
namespace App\Objet;
/*
Author: fpodev (fpodev@gmx.fr)
User.php (c) 2020
Desc: L'objet user
Created:  2020-04-14T08:10:34.130Z
Modified: !date!
*/

use App\Objet\ExtendsObjet;

class User extends ExtendsObjet
{        
    private $prenom,
            $email,
            $pwd,
            $lieu,
            $niveau,
            $userAdd,
            $userModif,
            $id_lieu;
   
    const PRENOM_INVALIDE = 2,
          EMAIL_INVALIDE = 3, 
          LIEU_INVALIDE = 4, 
          NIVEAU_INVALIDE = 5;        
        
    public function isValid()
    {
        return !(empty($this->nom) || empty($this->prenom) 
                || empty($this->email || empty($this->niveau) || empty($this->lieu)));
    }    
    //setter    
    public function setLieu($lieu)
    {          
        if(empty($lieu))
        {
            $this->erreurs[] = self::LIEU_INVALIDE;
        }
        else
        {
            $this->lieu = $lieu;
        }
    }      
    public function setPrenom($prenom)
    {
        if(!is_string($prenom) || empty($prenom))
        {
            $this->erreurs[] = self::PRENOM_INVALIDE;
        }
        else
        {
           $this->prenom = $prenom; 
        }
    }
    public function setEmail($email)
    {
       if(!is_string($email)|| empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) 
       {
           $this->erreurs[] = self::EMAIL_INVALIDE;
       }
       else
       {
           $this->email = $email;
       }
    }
    public function setPwd($pwd)
    {              
           $this->pwd = $pwd;          
    }
    public function setNiveau($niveau)
    {
        if(empty($niveau)) 
        {
            $this->erreurs[] = self::NIVEAU_INVALIDE;
        }
        else
        {
            $this->niveau = $niveau;
        }
    }
    public function setUserAdd($userAdd)
    {        
        $this->userAdd = $userAdd;
    }
    public function setUserModif($userModif)
    {
        $this->userModif = $userModif;
    }
    public function setId_lieu($id_lieu)
    {
        $this->id_lieu = $id_lieu;
    }  
    //getter
    
    public function lieu()
    {
        return $this->lieu;
    }    
    public function prenom()
    {
        return $this->prenom;
    }
    public function email()
    {
        return $this->email;
    }
    public function pwd()
    {
        return $this->pwd;
    }
    public function niveau()
    {
        return $this->niveau;
    }
    public function userAdd()
    {
        return $this->userAdd;
    }
    public function userModif()
    {
        return $this->userModif;
    }
    public function id_lieu()
    {
        return $this->id_lieu;
    }

}

