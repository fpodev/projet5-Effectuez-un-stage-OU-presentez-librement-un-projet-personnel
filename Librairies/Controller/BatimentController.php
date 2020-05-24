<?php
/*
Author: fpodev (fpodev@gmx.fr)
BatimentController.php (c) 2020
Desc: script controle des batiments
Created:  2020-04-14T08:10:34.130Z
Modified: !date!
*/
namespace App\Controller;

use App\Objet\Batiment;
use App\ConnexionBDD\ConnexionDb;
use App\model\BatimentModel;
use App\Controller\VueController;
use App\Controller\LieuController;

class BatimentController { 
    
        private $batiment;
        private $ville;

    public function __construct(){
        $db = ConnexionDb::getPDO();
        $this->batiment = new BatimentModel($db);
        $this->render = new VueController();
        $this->ville = new LieuController();                       
    }
    public function batimentList($id = null, $erreur = null){
        if($id == null){
            $id = $_SESSION['lieuId'];
       }       
            //Renvoie $id à la fonction verif, celle-ci renverra une erreur 404 si il y n'y as pas de corespondance.                    
            $ville = $this->ville->verif($id);
            if($ville == true)
            {
                $valueList = $this->batiment->batimentList($id);
                $title = 'bâtiments';                                                                  
                $_SESSION['lieuVue'] = $ville->nom();
                $_SESSION['id_lieu'] = $ville->id();                     
                $this->render->view('ActifList', ['value' => $valueList, 'title' => $title, 'erreur' => $erreur]);                            
            }                       
    }  
    public function addBatiment(){   
        $nom = htmlspecialchars($_POST['bâtiments']);                
        $batiment = new Batiment(
            [
                'nom' => $nom, 
                'id_lieu'  => $_SESSION['id_lieu']                                             
            ]);
                
            if(isset($_POST['id']))
            {
                $batiment->setId($_POST['id']);
            }
            if($batiment->isValid())
            { 
                $this->batiment->save($batiment);                
                
                $this->batimentList($_SESSION['id_lieu']); 
            }
            else
            {
                    $erreurs = $batiment->erreurs();                     
                    
                $this->batimentList($_SESSION['id_lieu'], $erreurs);                                                      
            }               
    } 
    public function uniqueBatiment($id, $erreur = null){        
            $value = $this->verif($id);
            if($value == true){
                $title = 'bâtiments';
                $this->render->view('ActifList',['value' => $value, 'title' => $title, 'erreur'=>$erreur]);
            }                
    }
    public function updateBatiment(){
        $value = htmlspecialchars($_POST['bâtiments']);                 
        $batiment = new Batiment(
            [
                'nom' => $value,                                                 
            ]);

            if(isset($_POST['id']))
            {
                $batiment->setId($_POST['id']);
            }
            if($batiment->isValidUpdate())
            {
                $this->batiment->save($batiment);                
                
                $this->batimentList($_SESSION['id_lieu']); 
            } 
            else
            {
                $erreurs = $batiment->erreurs();                     
                    
                $this->uniqueBatiment($_POST['id'], $erreurs);                                                      
            }               
                           
    }
    public function supprimeBatiment($id){
       $batiment = $this->verif($id);
       if($batiment == true){
        $this->batiment->delete($id);   
        $this->batimentList();  
       }         
    } 
    
    public function Verif($id){    
        $idValid =  htmlspecialchars($id);           
        //S'assure que l'$id est bien un nombre avant de faire la requéte dans la BDD sinon 404.                              
        if (preg_match("#[0-9]#", $idValid))
        {
            //Vérifie que l'entrée existe bien dans la BDD et renvoi les valeurs, sinon 404.
            $batiment = $this->batiment->uniqueBatiment($idValid);        
            if($batiment != false){
                return $batiment; 
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
