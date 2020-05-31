<?php

use App\Controller\ApiController;

require '../../vendor/autoload.php'; 
/*
Author: fpodev (fpodev@gmx.fr)
ApiPost.php (c) 2020
Desc: Gére les informations reçu du client via ajax.
Created:  2020-05-01T09:01:54.651Z
Modified: !date!
*/
// Accès depuis n'importe quel site ou appareil (*)
header("Access-Control-Allow-Origin: *");
// Format des données envoyées
header("Content-Type: application/json; charset=UTF-8");
// Méthode autorisée
header("Access-Control-Allow-Methods: POST");
// Durée de vie de la requête
header("Access-Control-Max-Age: 3600");
// Entêtes autorisées
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
  $donnees = json_decode(file_get_contents("php://input"));
  $post = new ApiController();
  if(!empty($donnees->id_debut)){
    $message = $post->debut($donnees);    
    $retour['valeur'] = $message;
  }
  else{
    $message = $post->fin($donnees);
    $retour['valeur'] = $message;
  }    
  echo json_encode($retour);
 
