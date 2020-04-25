<?php
/*
Author: fpodev (fpodev@gmx.fr)
SecteurController.php (c) 2020
Desc: Le controller pour gérer les zones d'un batiment
Created:  2020-04-14T09:23:38.570Z
Modified: !date!
*/
namespace App\Controller;

use App\View\Render;
use App\Objet\Secteur;
use App\Objet\ConnexionDb;
use App\model\BatimentModel;
use App\model\SecteurModel;
use Twig\Extension\MyExtends;

class SecteurController { 
    
        private $secteur;
        private $batiment;

    public function __construct(){
        $db = ConnexionDb::getPDO();
        $this->secteur = new SecteurModel($db);
        $this->render = new Render();
        $this->batiment = new BatimentModel($db);                       
    }
    public function secteurList($id){
        if(preg_match("#[0-9]#" , $id))
            {     
                $title = 'secteurs'; 
                $batiment = $this->batiment->uniqueBatiment($id);
                $valueList = $this->secteur->secteurList($id);
                $_SESSION['batiment'] = $batiment->nom();

                $this->render->view('ActifList', ['value' => $valueList, 'title' => $title]);                         
            } 
            else{
                echo 'erreur 404';
            }                      
    }
    public function addSecteur(){                   
        $secteur = new Secteur(
            [
                'nom' => $_POST['name'], 
                'id_batiment'  => $_POST['id_batiment']                                              
            ]);

            if(isset($_POST['id']))
            {
                $secteur->setId($_POST['id']);
            }
            if($secteur->isValid())
            {
                $this->secteur->save($secteur);                
                
                $this->secteurList($_POST['id_lieu']); 
            }
            else
            {
                    $erreurs = $secteur->erreurs();                     
                
                    $this->render->view('CreateSite', ['secteur' => $erreurs]);                                                      
            }               
    }
    public function sitePage(){
        $this->render->view('CreateSite');  
    }         
}

