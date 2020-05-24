<?php
/*
Author: fpodev (fpodev@gmx.fr)
MaterielController.php (c) 2020
Desc: 
Created:  2020-04-14T14:53:04.896Z
Modified: !date!
*/
namespace App\Controller;

use App\Objet\Materiel;
use App\ConnexionBDD\ConnexionDb;
use App\model\MaterielModel;
use App\Controller\VueController;
use App\Controller\SecteurController;

class MaterielController { 
    
        private $materiel;
        private $secteur;        

    public function __construct(){
        $db = ConnexionDb::getPDO();
        $this->materiel = new MaterielModel($db);
        $this->render = new VueController();  
        $this->secteur = new SecteurController();                          
    }
    public function materielList($id, $erreur = null){       
            $secteur = $this->secteur->verif($id); 
            if($secteur == true){                          
                $valueList = $this->materiel->materielList($secteur->id());
                $title = 'matériels';
                $_SESSION['secteur'] = $secteur->nom();
                $_SESSION['id_secteur'] = $secteur->id();
               
                $this->render->view('ActifList', ['value' => $valueList, 'title' => $title, 'erreur' => $erreur]);                          
            }                 
    }            
    public function addMateriel(){  
            $nom = htmlspecialchars($_POST['matériels']);
        $materiel = new Materiel(
            [
                'nom' => $nom, 
                'id_secteur'  => $_SESSION['id_secteur']                                              
            ]);

            if(isset($_POST['id']))
            {
                $materiel->setId($_POST['id']);
            }
            if($materiel->isValid())
            {
                $this->materiel->save($materiel);                
                
                $this->materielList($_SESSION['id_secteur']); 
            }
            else
            {
                    $erreurs = $materiel->erreurs();                     
                
                    $this->materielList($_SESSION['id_secteur'], $erreurs);                                                      
            }               
    }
    public function uniqueMateriel($id, $erreur= null){
        $value = $this->verif($id);
        if($value == true){
            $title = 'matériels';
            $this->render->view('ActifList',['value' => $value, 'title' => $title, 'erreur' => $erreur]);
        }             
    }
    public function updateMateriel(){

        $value = htmlspecialchars($_POST['matériels']);                 
        $materiel = new materiel(
            [
                'nom' => $value,                                                 
            ]);

            if(isset($_POST['id']))
            {
                $materiel->setId($_POST['id']);
            }
            if($materiel->isValidUpdate())
            {
                $this->materiel->save($materiel);                
                
                $this->materielList($_SESSION['id_secteur']); 
            }
            else
            {
                $erreurs = $materiel->erreurs();                     
                
                $this->uniqueMateriel($_POST['id'], $erreurs);                                               
            }                          
    }
    public function supprimeMateriel($id){
        $materiel = $this->verif($id);
        if($materiel == true){
            $this->materiel->delete(($id));   
            $this->materielList($_SESSION['id_secteur']); 
        }       
    } 
    /*verification que l'élement demandé via un $id est bien un nombre
    ** et existe bien dans la BDD avant de retourné ses valeurs*/
    public function Verif($id){    
        $idValid =  htmlspecialchars($id);                                               
        if (preg_match("#[0-9]#", $idValid))
        {
            $materiel = $this->materiel->uniqueMateriel($idValid);        
            if($materiel != false){
                return $materiel;
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


