<?php
namespace App\Objet;

use App\Objet\AbstractClass;

class User extends AbstractObjet
{    
    private $nom;
    private $prenom;
    private $email;
    private $pwd;
    private $lieu;
    private $niveau;
    private $userAdd;
    private $userModif;

    const NOM_INVALIDE = 1;
    const PRENOM_INVALIDE = 2;
    const EMAIL_INVALIDE = 3; 
    const LIEU_INVALIDE = 4; 
    const NIVEAU_INVALIDE = 5;        
 
    public function isValid()
    {
        return !(empty($this->nom) || empty($this->prenom) || empty($this->email || empty($this->niveau)));
    }
    //setter    
    public function setLieu($lieu)
    {
        if($lieu === 'Choisir une ville')
        {
            $this->erreurs[] = self::LIEU_INVALIDE;
        }
        else
        {
            $this->lieu = $lieu;
        }
    }
    public function setNom($nom)
    {
        if(!is_string($nom) || empty($nom))
        {
            $this->erreurs[] = self::NOM_INVALIDE;
        }
        else
        {
            $this->nom = $nom;
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
       if(!is_string($email)|| empty($email) || !preg_match('/(@)(.)/' , $email)) 
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
    //getter
    
    public function lieu()
    {
        return $this->lieu;
    }
    public function nom()
    {
        return $this->nom;
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
}

