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
use App\Controller\UserController;

class TravauxController {

    private $travaux; 
    private $batiment;  
    private $ville;
    private $materiel;
    private $secteur;   

    public function __construct(){
        $db = ConnexionDb::getPDO();
        $this->userCtrl = new UserController();
        $this->render = new Render();  
        $this->travaux = new TravauxModel($db);   
        $this->ville = new LieuModel($db);         
        $this->secteur = new SecteurModel($db);
        $this->user = new UserModel($db);
        $this->materiel = new MaterielModel($db);
        $this->batiment = new BatimentModel($db);
        $this->date = new \DateTime();
    }
    
    public function travauxTech(){                                                    
            $title = "Liste de mes travaux";                

            $this->render->view('TravauxTech',['title' => $title]);              
    }
    public function travauxList(){
        if(stristr((urldecode($_SERVER['REQUEST_URI'])), 'travaux-planifiés')){
            $title = "Liste des travaux planifiés";                
            $param = 'NOT NULL';
            $etat ='1';
            
        }                       
        else
        {
            $title = "Liste des nouvelles demandes de travaux";                
            $param = 'NULL';
            $etat = '2';
        }
        $valueList = $this->travaux->travauxList($param);
       
        $this->render->view('TravauxList',['title' => $title, 'tvx' => $valueList, 'planif'=> $etat]);               

    }
    public function uniqueTravaux($id){
            $_SESSION['lieuId'] = "null";
            $id = $id;
            $title = "Planification des travaux demandés";
            $value = $this->travaux->uniqueTravaux($id);                    
            $techList = $this->user->listTech($_SESSION['lieuId']);
           
            $this->render->view('PlanifTravaux', ['title' => $title,'tvx' => $value, 'tech' => $techList]);
    }
    public function addTravaux(){                   
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
                ]            
                );
                              
        if($travaux->validDemande()) 
        {            
            $this->travaux->save($travaux);
        }
        else
        {
            $erreurs = $travaux->erreurs();                     
            
            $this->render->view('DemandeTvx', ['tvx' => $erreurs]); 
        } 
         $this->userCtrl->home();        
    }
    public function planifTravaux(){
            $travaux = new Travaux(                     
                [        
                    'descriptions' => $_POST['descriptions'],
                    'detail' => $_POST['detail'],                               
                    'id_technicien' =>  $_POST['id_technicien'],                            
                    'date_prevu' => $_POST['date_prevu'],                                      
                    'externe' => $_POST['externe'],                              
                ]            
                ); 
                 
        if(isset($_POST['id']))  
        {
            $travaux->setId($_POST['id']);
        }        
        if($travaux->validPlanif()) 
        { 
            $this->travaux->save($travaux);
            $this->travauxList();
        }
        else
        {
            $erreurs = $travaux->erreurs();                     
            
            $this->render->view('PlanifTravaux', ['tvx' => $erreurs]);
        }
    } 
    public function startTravaux($donnee){        
        $travaux = new Travaux(                     
            [                                                                                                              
                'date_debut' => $this->date->format('d-m-Y H:i:s'),                                                                 
            ]            
            ); 
               
        if(isset($donnee->id))  
        {
            $travaux->setId($donnee->id);
        }      
        if($travaux->validStart()) 
        { 
            $this->travaux->save($travaux);                      
        }
        else
        {
            $erreurs = $travaux->erreurs();                     
            
            $this->render->view('DemandeTvx', ['tvx' => $erreurs]);
        }
    }  
    public function valid($travaux){
            
    }
    public function closeTravaux(){        
        $travaux = new Travaux(                     
            [                                                                                                        
               'date_fin'=> $this->date->format('Y-m-d H:i:s'),                                         
            ]            
            );                 
        if(isset($_POST['id']))  
        {
            $travaux->setId($_POST['id']);
        }
        
        if($travaux->validClose()) 
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
                elseif(stristr((urldecode($_SERVER['REQUEST_URI'])), 'Bâtiment', true))
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

   public function deleteTravaux($id){
       
        $this->travaux->delete($id);     

        $this->travauxList();
                
   }
}    
