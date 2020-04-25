<?php
/*
Author: fpodev (fpodev@gmx.fr)
TravauxController.php (c) 2020
Desc: description
Created:  2020-04-20T08:32:18.988Z
Modified: !date!
*/
namespace App\Controller;

use App\View\Render;
use App\Objet\Travaux;
use App\model\LieuModel;
use App\model\UserModel;
use App\Objet\ConnexionDb;
use App\model\SecteurModel;
use App\model\TravauxModel;
use App\model\BatimentModel;
use App\model\MaterielModel;

class TravauxController {

    private $travaux; 
    private $batiment;  
    private $ville;
    private $materiel;
    private $secteur;   

    public function __construct(){
        $db = ConnexionDb::getPDO();
        $this->render = new Render();  
        $this->travaux = new TravauxModel($db);   
        $this->ville = new LieuModel($db);         
        $this->secteur = new SecteurModel($db);
        $this->user = new UserModel($db);
        $this->materiel = new MaterielModel($db);
        $this->batiment = new BatimentModel($db);
    }
    public function travauxList(){                         
            $title = "Liste des demandes de travaux";                
            $valueList = $this->travaux->travauxList(); 

            $this->render->view('TravauxList',['title' => $title, 'tvx' => $valueList]);              
    }
    public function uniqueTravaux($id){
            $id = $id;
            $title = "Planification des travaux demandés";
            $value = $this->travaux->uniqueTravaux($id);           
            $techList = $this->user->listTech($value["nLieu"]);
            

           $this->render->view('PlanifTravaux', ['title' => $title,'tvx' => $value, 'tech' => $techList, "id" => $id]);
    }
    public function addTravaux(){ 
            $datePrev =  $_POST['date_prevu'];
            if($_POST['id_technicien'] = "");
            if($datePrev == "")
            {
                $datePrev = "";
            } 
            else{ $_POST['date_prevu'] = $_POST['date_prevu'];}

            $travaux = new Travaux(                     
                [               
                    'id_lieu' => $_POST['id_lieu'],
                    'id_batiment' => $_POST['id_batiment'],
                    'id_secteur' => $_POST['id_secteur'],
                    'id_materiel' => $_POST['id_materiel'],
                    'id_demandeur' => $_POST['id_demandeur'],                
                    'descriptions' => $_POST['descriptions'],
                    'detail' => $_POST['detail'],
                    'urgence' => $_POST['urgence'], 
                    'descriptions' => $_POST['descriptions'],
                    'detail' => $_POST['detail']                  
                   /* 'id_technicien' =>  $_POST['id_technicien'],                                
                    'date_prevu' => $_POST['date_prevu'],                    
                    //'date_debut' => $_POST['date_debut'],                
                 //   'date_fin'=> $_POST['date_fin'],  
                   // 'externe' => $_POST['externe'], */                             
                ]            
                ); 
        var_dump($travaux);   
        if(isset($_POST['id']))  
        {
            $travaux->setId($_POST['id']);
        }
        if($travaux->isValid()) 
        {   
         
            $this->travaux->save($travaux);
        }
        else
        {
            $erreurs = $travaux->erreurs();                     
            
            $this->render->view('DemandeTvx', ['tvx' => $erreurs]); 
        }             
    }
    public function planifTravaux(){
            $travaux = new Travaux(                     
                [             
                                
                                      
                ]            
                ); 
      
        if(isset($_POST['id']))  
        {
            $travaux->setId($_POST['id']);
        }
        if($travaux->isValid()) 
        { 
            $this->travaux->save($travaux);
            $this->travauxList();
        }
        else
        {
            $erreurs = $travaux->erreurs();                     
            
            $this->render->view('DemandeTvx', ['tvx' => $erreurs]);
        }
    }       
    public function travauxPage($id = null){
        if($id == null){            
            $id = $_SESSION['lieuId'];            
        }            
        if(preg_match("#[0-9]#", $id))
            {                                                   
                if(stristr($_SERVER['REQUEST_URI'], 'Demande-Travaux'))                
                {
                    $title = 'bâtiment';  
                    $ville = $this->ville->uniqueLieu($id);   
                    $_SESSION['lieuVue'] = $ville->nom();                
                    $valueList = $this->batiment->batimentList($id);                    
                }                                
                elseif(stristr($_SERVER['REQUEST_URI'], 'Batiment', true))
                {  
                    $title = 'secteur';  
                    $valueList = $this->secteur->secteurList($id);  
                    $batiment = $this->batiment->uniqueBatiment($id);
                    $_SESSION['batiment'] = $batiment->nom(); 
                    $_SESSION['batimentId'] = $batiment->id();
                }
                elseif(stristr($_SERVER['REQUEST_URI'], 'Secteur'))
                {
                    $title = 'matériel'; 
                    $valueList = $this->materiel->materielList($id);
                    $secteur = $this->secteur->uniqueSecteur($id);
                    $_SESSION['secteur'] = $secteur->nom();  
                    $_SESSION['secteurId'] = $secteur->id();                                       
                }                                                                                       
                $this->render->view('ActifTvx', ['value' => $valueList, 'title' => $title]); 
            }
            else{
                echo 'erreur 404';
            }            
    }
    public function formulaireTravaux($id = null){
        if($id == null){            
            $id = $_SESSION['lieuId'];            
        }        
        if(preg_match("#[0-9]#", $id))
        {
            $title = 'Formulaire demande de travaux';
            $materiel = $this->materiel->uniqueMateriel($id);
            $_SESSION['materiel'] = $materiel->nom();
            $_SESSION['materielId'] = $materiel->id();

            $this->render->view('DemandeTvx', ['title' => $title]);
        }
    } 
   
}    
