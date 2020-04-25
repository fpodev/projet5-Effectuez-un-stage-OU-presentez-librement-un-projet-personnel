<?php 
/*
Author: fpodev (fpodev@gmx.fr)
SiteController.php (c) 2020
Desc: controller ajout lieu
Created:  2020-04-14T07:21:19.189Z
Modified: !date!
*/
namespace App\Controller;

use App\Objet\Lieu;
use App\View\Render;
use App\model\LieuModel;
use App\Objet\ConnexionDb;
use Twig\Extension\MyExtends;

class LieuController { 
    
        private $lieu;

    public function __construct(){
        $db = ConnexionDb::getPDO();
        $this->lieu = new LieuModel($db);
        $this->render = new Render();                        
    }
    public function lieuList(){

        $title = 'villes';
        $valueList = $this->lieu->lieuList();       
        $this->render->view('ActifList',['value' => $valueList, 'title' => $title]);
    }
    public function addSite(){                   
        $lieu = new Lieu(
            [
                'lieu' => $_POST['lieu'],                                                 
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
                
                    $this->render->view('CreateSite', ['lieu' => $erreurs]);                                                      
            }               
    }
    public function sitePage(){
        $this->render->view('CreateSite');  
    }         
}