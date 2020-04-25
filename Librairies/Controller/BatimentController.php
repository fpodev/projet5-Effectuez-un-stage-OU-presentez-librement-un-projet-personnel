<?php
/*
Author: fpodev (fpodev@gmx.fr)
BatimentController.php (c) 2020
Desc: description
Created:  2020-04-14T08:10:34.130Z
Modified: !date!
*/
namespace App\Controller;

use App\View\Render;
use App\Objet\Batiment;
use App\Objet\ConnexionDb;
use App\model\BatimentModel;
use App\model\LieuModel;
use Twig\Extension\MyExtends;

class BatimentController { 
    
        private $batiment;
        private $ville;

    public function __construct(){
        $db = ConnexionDb::getPDO();
        $this->batiment = new BatimentModel($db);
        $this->render = new Render();
        $this->ville = new LieuModel($db);                       
    }
    public function batimentList($id = null){
        if($id == null){
            $id = $_SESSION['lieuId'];
        }        
        if(preg_match("#[0-9]#" , $id))
            {
                $title = 'bâtiments';
                $ville = $this->ville->uniqueLieu($id);             
                $valueList = $this->batiment->batimentList($id);                         
                $_SESSION['lieuVue'] = $ville->nom();                      
                $this->render->view('ActifList', ['value' => $valueList, 'title' => $title]);                            
            } 
            else{
                echo 'erreur 404';
            }                      
    }  
    public function addSite(){                   
        $batiment = new Batiment(
            [
                'nom' => $_POST['name'], 
                'id_lieu'  => $_POST['id_lieu']                                              
            ]);

            if(isset($_POST['id']))
            {
                $batiment->setId($_POST['id']);
            }
            if($batiment->isValid())
            {
                $this->batiment->save($batiment);                
                
                $this->batimentList($_POST['id_lieu']); 
            }
            else
            {
                    $erreurs = $batiment->erreurs();                     
                
                    $this->render->view('CreateSite', ['batiment' => $erreurs]);                                                      
            }               
    }
    public function sitePage(){
        $this->render->view('CreateSite');  
    }         
}
