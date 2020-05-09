<?php
namespace App\Controller;

/*
Author: fpodev (fpodev@gmx.fr)
ApiController.php (c) 2020
Desc: description
Created:  2020-05-02T16:08:19.250Z
Modified: !date!
*/
use App\Objet\Travaux;
use App\Objet\ConnexionDb;
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
              $nombres = $this->travaux->countAll(); 
              $valueList = $this->travaux->technicienList($_SESSION['id_user']);  
                                                                                
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
    return $message = "l'heure debut bien ajoutée";
    }
    else{
     http_response_code(503);
     return $message = " l'heure debut n'a pas été ajoutée";
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
    return $message = "l'heure de fin bien ajoutée";
    }
    else{
     http_response_code(503);
     return $message = " l'heure de fin n'a pas été ajoutée";
    }    

}
}

  

  






    

