<?php
/*
Author: fpodev (fpodev@gmx.fr)
SecteurController.php (c) 2020
Desc: Le controller pour gérer les zones d'un batiment
Created:  2020-04-14T09:23:38.570Z
Modified: !date!
*/
namespace App\Controller;

use App\Objet\Secteur;
use App\ConnexionBDD\ConnexionDb;
use App\model\SecteurModel;
use App\Controller\VueController;
use App\Controller\BatimentController;

class SecteurController { 
    
        private $secteur;
        private $batiment;

    public function __construct(){
        $db = ConnexionDb::getPDO();
        $this->secteur = new SecteurModel($db);
        $this->render = new VueController();
        $this->batiment = new BatimentController($db);                       
    }
    public function secteurList($id = null, $erreur = null){
        if($id === null){
            $id = $_SESSION['id_batiment'];
        }        
                $batiment = $this->batiment->verif($id);
                if($batiment == true){                  
                $title = 'secteurs';                 
                $valueList = $this->secteur->secteurList($id);
                $_SESSION['batiment'] = $batiment->nom();
                $_SESSION['id_batiment'] = $batiment->id();

                $this->render->view('ActifList', ['value' => $valueList, 'title' => $title, 'erreur' => $erreur]);                         
            }             
    }
    public function addSecteur(){   
        $nom = htmlspecialchars($_POST['secteurs']);                
        $secteur = new Secteur(
            [
                'nom' => $nom, 
                'id_batiment'  => $_SESSION['id_batiment']                                              
            ]);            
            if($secteur->isValid())
            {
                $this->secteur->save($secteur);                
                
                $this->secteurList($_SESSION['id_batiment']); 
            }
            else
            {
                    $erreurs = $secteur->erreurs();                     
                
                    $this->secteurList($_SESSION['id_batiment'], $erreurs);                                                      
            }               
    }
    public function uniqueSecteur($id, $erreur = null){
            $value = $this->verif($id);
            if($value == true){
                $title = 'Secteurs';
                $this->render->view('ActifList',['value' => $value, 'title' => $title, 'erreur' => $erreur]); 
            }                  
    }
    public function updateSecteur(){
        $value = htmlspecialchars($_POST['Secteurs']);                 
        $secteur = new secteur(
            [
                'nom' => $value,                                                 
            ]);

            if(isset($_POST['id']))
            {
                $secteur->setId($_POST['id']);
            }
            if($secteur->isValidUpdate())
            {
                $this->secteur->save($secteur);                
                
                $this->secteurList($_SESSION['id_batiment']); 
            }
            else
            {
                $erreurs = $secteur->erreurs();                     
                
                $this->uniqueSecteur($_SESSION['id_batiment'], $erreurs);
            }                          
    }
    public function supprimeSecteur($id){
        $secteur = $this->verif($id);
        if($secteur == true){
            $this->secteur->delete($id);    
            $this->secteurList($_SESSION['id_batiment']); 
        }                                 
    } 
    /*verification que l'élement demandé via un $id est bien un nombre
    ** et existe bien dans la BDD avant de retourné ses valeurs*/  
    public function Verif($id){    
        $idValid =  htmlspecialchars($id);           
                                      
        if (preg_match("#[0-9]#", $idValid))
        {
            $secteur = $this->secteur->uniqueSecteur($idValid);        
            if($secteur != false){
                return $secteur; 
            }
            else{
                $this->render->view('404');
            }                               
        } 
        else{                             
            $this->render->view('404');                        
        }           
    }    
}

