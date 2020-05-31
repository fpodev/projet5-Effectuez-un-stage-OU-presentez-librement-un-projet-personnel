<?php
namespace App\Controller;

/*
Author: fpodev (fpodev@gmx.fr)
ApiController.php (c) 2020
Desc: Gére les informations reçus ou envoyés avec l'api pour traitement avec la BDD
Created:  2020-05-02T16:08:19.250Z
Modified: !date!
*/
use App\Objet\Travaux;
use App\ConnexionBDD\ConnexionDb;
use App\model\TravauxModel;

class ApiController{

     private $travaux;
     private $date;

public function __construct(){
    $db = ConnexionDb::getPDO();  
    $this->travaux = new TravauxModel($db);           
    $this->date = new \DateTime();
}
public function api(){                   
            if(isset($_SESSION['id_user']) && isset($_SESSION['lieuId'])){
               $valueList = $this->travaux->technicienList($_SESSION['id_user'], ($_SESSION['lieuId']));                
            }                                                                  
              include ('Librairies/Api/ApiGet.php');                            
  }
public function debut($donnee){
   
  $travaux = new Travaux(                     
    [                                                                                                              
        'date_debut' => $this->date->format('Y-m-d H:i:s'),                                                                 
    ]            
    );
    if(isset($donnee->id_debut)) 
    {
    $travaux->setId($donnee->id_debut);
    }      
    if($travaux->validStart()) 
    { 
    $this->travaux->save($travaux);

    http_response_code(201);   
    return $message = "Début de travaux enregistré";
    }
    else{
     http_response_code(503);
     return $message = "Début de travaux non enregistré";     
    }    
    
}
public function fin($donnee){
  $travaux = new Travaux(                     
    [                                                                                                              
        'date_fin' => $this->date->format('Y-m-d H:i:s'),                                                                 
    ]            
    );
    if(isset($donnee->id_fin)) 
{
    $travaux->setId($donnee->id_fin);
}      
if($travaux->validClose()) 
{ 
   $this->travaux->save($travaux);
    http_response_code(201);
    return $message = "Fin de travaux enregistré";
    }
    else{
     http_response_code(503);
     return $message = "Fin de travaux non enregistré";
    }    

}
}

  

  






    

