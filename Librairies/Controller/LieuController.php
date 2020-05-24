<?php 
/*
Author: fpodev (fpodev@gmx.fr)
LieuController.php (c) 2020
Desc: Gére les lieux (villes).
Created:  2020-04-14T07:21:19.189Z
Modified: !date!
*/
namespace App\Controller;

use App\Objet\Lieu;
use App\model\LieuModel;
use App\ConnexionBDD\ConnexionDb;
use App\Controller\VueController;

class LieuController { 
    
        private $lieu;

    public function __construct(){
        $db = ConnexionDb::getPDO();
        $this->lieu = new LieuModel($db);
        $this->render = new VueController();                        
    }
    public function lieuList($erreur = null){
        $title = 'villes';
        $valueList = $this->lieu->lieuList();       
        $this->render->view('ActifList',['value' => $valueList, 'title' => $title, 'erreur' => $erreur]);
    }
    public function addLieu(){  
        $value = htmlspecialchars($_POST['villes']);                 
        $lieu = new Lieu(
            [
                'nom' => $value,                                                 
            ]);           
            if($lieu->isValid())
            {
                $this->lieu->save($lieu);                
                
                $this->lieuList(); 
            }
            else
            {
                $erreurs = $lieu->erreurs();                  
                $this->lieuList($erreurs);    
            }                          
    }
    public function uniqueLieu($id,$erreur = null ){
         $value = $this->verif($id);
        if($value == true){
            $title = 'villes';
            $this->render->view('ActifList',['value' => $value, 'title' => $title, 'erreur' => $erreur]);
        }        
    }
    public function updateLieu(){
        $value = htmlspecialchars($_POST['villes']);                 
        $lieu = new Lieu(
            [
                'nom' => $value,                                                 
            ]);

            if(isset($_POST['id']))
            {
                $lieu->setId($_POST['id']);
            }
            if($lieu->isValid())
            {
                $this->lieu->save($lieu);                
                
                $this->lieuList(); 
            }
            else
            {
                $erreurs = $lieu->erreurs();                     
                
                $this->uniqueLieu($_POST['id'], $erreurs);                                                 
            }                          
    }    
    public function supprimeLieu($id){
        $lieu = $this->verif($id);
        if($lieu == true){
            $this->lieu->delete($lieu->id());     

            $this->lieuList(); 
        }                          
    }
    /*verification que l'élement demandé via un $id est bien un nombre
    ** et existe bien dans la BDD avant de retourné ses valeurs*/
    public function Verif($id){    
        $idValid =  htmlspecialchars($id);           
                                      
        if (preg_match("#[0-9]#", $idValid))
        {
            $lieu = $this->lieu->uniqueLieu($idValid);        
            if($lieu != false){
                return $lieu;
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