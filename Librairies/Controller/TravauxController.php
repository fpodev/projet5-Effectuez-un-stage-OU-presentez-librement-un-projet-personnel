<?php
/*
Author: fpodev (fpodev@gmx.fr)
TravauxController.php (c) 2020
Desc: script de controle pour les travaux.
Created:  2020-04-20T08:32:18.988Z
Modified: !date!
*/
namespace App\Controller;

use App\Objet\Travaux;
use App\model\LieuModel;
use App\model\UserModel;
use App\ConnexionBDD\ConnexionDb;
use App\model\SecteurModel;
use App\model\TravauxModel;
use App\model\BatimentModel;
use App\model\MaterielModel;
use App\Controller\VueController;
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
        $this->render = new VueController;  
        $this->travaux = new TravauxModel($db);   
        $this->ville = new LieuModel($db);         
        $this->secteur = new SecteurModel($db);
        $this->user = new UserModel($db);
        $this->materiel = new MaterielModel($db);
        $this->batiment = new BatimentModel($db);
        $this->date = new \DateTime();
    }
    /*affiche les travaux programmés pour un niveau 2*/
    public function travauxTech(){                                                    
            $title = "Liste de mes travaux";                

            $this->render->view('TravauxTech',['title' => $title]);              
    }
    /*$etat permet de gérer les différents droit sur la page afiché*/
    /*$param permet de chercher dans la BDD les travaux planifié ou non*/
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
            $id = $id;        
                                                 
            $value = $this->verif($id);

            if($value != FALSE){                
                foreach($value as $idLieu)  
                         
                $techList = $this->user->listTech($idLieu['nLieu']);  

                if(stristr($_SERVER['REQUEST_URI'], 'edit-travaux=')){
                    $title = "Modifier la demande de travaux";                
                }
                elseif(stristr($_SERVER['REQUEST_URI'], 'voir=')){          
                    $title = "Voici la demande de travaux";              
                }
                else{
                    $title = "Planification de la demande de travaux";                
                }
                $this->render->view('PlanifTravaux', ['title' => $title,'tvx' => $value, 'tech' => $techList]); 
                }                                      
    }          
    public function addTravaux(){  
        $description = htmlspecialchars($_POST['descriptions']);
        $detail = htmlspecialchars($_POST['detail']);
        $urgence = htmlspecialchars($_POST['urgence']);       
            $travaux = new Travaux(                     
                [               
                    'id_lieu' => $_POST['id_lieu'],
                    'id_batiment' => $_POST['id_batiment'],
                    'id_secteur' => $_POST['id_secteur'],
                    'id_materiel' => $_POST['id_materiel'],
                    'id_demandeur' => $_POST['id_demandeur'],                
                    'descriptions' => $description,                    
                    'urgence' => (int)$urgence,   
                    'detail' => $detail,                                                                          
                ]            
                );                              
        if($travaux->validDemande()) 
        {            
            $this->travaux->save($travaux);
            $this->travauxList();
        }
        else
        {
            $erreurs = $travaux->erreurs();                     
            $title = 'Formulaire demande de travaux';
            $this->render->view('DemandeTvx', ['tvx' => $erreurs, 'title' => $title]); 
        }             
    }
    public function planifTravaux(){
        $description = htmlspecialchars($_POST['descriptions']);
        $detail = htmlspecialchars($_POST['detail']); 
        
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
           
    public function travauxPage($id = null){
        if($id == null){            
            $id = $_SESSION['lieuId'];            
        }                       
        if(preg_match("#[0-9]#", $id))
            {                                                   
                if(stristr($_SERVER['REQUEST_URI'], 'Demande-Travaux'))                
                {
                    $title = 'bâtiment';  
                    $ville = $this->ville->uniqueLieu(htmlspecialchars($id));  
                    $_SESSION['lieuVue'] = $ville->nom();                
                    $valueList = $this->batiment->batimentList(htmlspecialchars($id));                    
                }                                
                elseif(stristr((urldecode($_SERVER['REQUEST_URI'])), 'Bâtiment', true))
                {  
                    $title = 'secteur';  
                    $batiment = $this->batiment->uniqueBatiment(htmlspecialchars($id));
                    $valueList = $this->secteur->secteurList(htmlspecialchars($id));                   
                    $_SESSION['batiment'] = $batiment->nom(); 
                    $_SESSION['batimentId'] = $batiment->id();
                }
                elseif(stristr($_SERVER['REQUEST_URI'], 'Secteur'))
                {
                    $title = 'matériel'; 
                    $valueList = $this->materiel->materielList(htmlspecialchars($id)); 
                    $secteur = $this->secteur->uniqueSecteur(htmlspecialchars($id));
                    $_SESSION['secteur'] = $secteur->nom();  
                    $_SESSION['secteurId'] = $secteur->id();                                       
                }                                                                                       
                $this->render->view('ActifTvx', ['value' => $valueList, 'title' => $title]); 
            }
            else{
                $this->render->view('404');
            }            
    }
    public function formulaireTravaux($id = null){
        if($id == null){            
            $id = $_SESSION['lieuId'];            
        }        
        if(preg_match("#[0-9]#", $id))
        {
            $title = 'Formulaire demande de travaux';
            $materiel = $this->materiel->uniqueMateriel(htmlspecialchars($id));
            $_SESSION['materiel'] = $materiel->nom();
            $_SESSION['materielId'] = $materiel->id();

            $this->render->view('DemandeTvx', ['title' => $title]);
        }
        else{
            $this->render->view('404');
        }
    }      

   public function deleteTravaux($id){      
        $travaux = $this->verif($id);
        if($travaux == true){           
            $this->travaux->delete($id);   
            $this->travauxList();
        }                            
   }
   /*verification que l'élement demandé via un $id est bien un nombre
    ** et existe bien dans la BDD avant de retourné ses valeurs*/
   public function verif($id){    
    $idValid =  htmlspecialchars($id);           
                                  
    if(preg_match("#[0-9]#", $idValid))
    {     
       $travaux = $this->travaux->uniqueTravaux(htmlspecialchars($id));          
        if($travaux != false){
            return $travaux;
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
