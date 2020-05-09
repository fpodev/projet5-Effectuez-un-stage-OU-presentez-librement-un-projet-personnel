<?php

/*
Author: fpodev (fpodev@gmx.fr)
index.php (c) 2020
Desc: description
Created:  2020-04-20T07:33:01.720Z
Modified: !date!
*/
// Accès depuis n'importe quel site ou appareil (*)
header("Access-Control-Allow-Origin: *");
// Format des données envoyées
header("Content-Type: application/json; charset=UTF-8");
// Méthode autorisée
header("Access-Control-Allow-Methods: GET");
// Durée de vie de la requête
header("Access-Control-Max-Age: 3600");
// Entêtes autorisées
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");      
      
            if(empty($valueList))
            {
                $retour["success"] = false;  
                $retour["message"] = "Aucun travaux";
            }
            else
            {
                $retour["success"] = true;  
                $retour["message"] = "Voici la liste des travaux planifiés";                                       
                $retour["travaux"] =  $valueList; 
           }      
      
echo json_encode($retour);
