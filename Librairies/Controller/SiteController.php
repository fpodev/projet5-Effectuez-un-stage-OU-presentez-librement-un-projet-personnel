<?php 
namespace App\Controller;

use App\Objet\Site;
use App\View\Render;
use App\model\SiteModel;
use App\Objet\ConnexionDb;
use Twig\Extension\MyExtends;


class SiteController { 
    
        private $site;

    public function __construct(){
        $db = ConnexionDb::getPDO();
        $this->site = new SiteModel($db);
        $this->render = new Render();                        
    }
    public function siteListe(){
        $siteList = $this->site->lieuList();

        $this->render->view('LieuList',['siteListe' => $siteList]);
    }
    public function addSite(){                   
        $user = new Site(
            [
                'ville' => $_POST['ville'],
                'batiment' => $_POST['batiment'],
                'secteur' => $_POST['secteur'],
                'materiel' => $_POST['materiel'],                                     
            ]);

            if(isset($_POST['id']))
            {
                $user->setId($_POST['id']);
            }
            if($user->isValid())
            {
                $this->user->save($lieu);                
                
                $this->listSite(); 
            }
            else
            {
                    $erreurs = $site->erreurs();                     
                
                    $this->view('CreateSite.twig', ['site' => $erreurs]);                                                      
            }               
    }
    public function sitePage(){
        $this->render->view('CreateSite',[]);  
    }         
}