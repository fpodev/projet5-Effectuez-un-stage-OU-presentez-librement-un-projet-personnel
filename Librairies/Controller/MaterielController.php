<?php
/*
Author: fpodev (fpodev@gmx.fr)
MaterielController.php (c) 2020
Desc: 
Created:  2020-04-14T14:53:04.896Z
Modified: !date!
*/
namespace App\Controller;

use App\View\Render;
use App\Objet\Materiel;
use App\Objet\ConnexionDb;
use App\model\SecteurModel;
use App\model\MaterielModel;
use Twig\Extension\MyExtends;

class MaterielController { 
    
        private $materiel;
        private $secteur;        

    public function __construct(){
        $db = ConnexionDb::getPDO();
        $this->materiel = new MaterielModel($db);
        $this->render = new Render();  
        $this->secteur = new SecteurModel($db);                          
    }
    public function MaterielList($id){
        if(preg_match("#[0-9]#" , $id))
            {         
                $secteur = $this->secteur->uniqueSecteur($id);   
                $valueList = $this->materiel->materielList($id);
                $title = 'matériels';

                $_SESSION['secteur'] = $secteur->nom();
               
                $this->render->view('ActifList', ['value' => $valueList, 'title' => $title]);                          
            } 
            else{
                echo 'erreur 404';
            }                      
    }
    public function addMateriel(){                   
        $materiel = new Materiel(
            [
                'nom' => $_POST['name'], 
                'id_batiment'  => $_POST['id_batiment']                                              
            ]);

            if(isset($_POST['id']))
            {
                $materiel->setId($_POST['id']);
            }
            if($materiel->isValid())
            {
                $this->materiel->save($materiel);                
                
                $this->materielList($_POST['id_lieu']); 
            }
            else
            {
                    $erreurs = $materiel->erreurs();                     
                
                    $this->render->view('CreateSite', ['secteur' => $erreurs]);                                                      
            }               
    }
    public function sitePage(){
        $this->render->view('CreateSite');  
    }         
}


