<?php
/*
Author: fpodev (fpodev@gmx.fr)
index.php (c) 2020
Desc: description
Created:  2020-04-13T09:42:15.632Z
Modified: !date!
*/

use App\Routeur\Routeur;
require 'vendor/autoload.php'; 

$router = new Routeur($_GET['url']);

$router->get('/', "User#home"); 
$router->get('/Accueil', 'User#home');
$router->post('/Accueil', "User#connexion"); 

$router->get('/Modifier=:id', "User#changeUser");
$router->get('/Gestion-Utilisateurs', "User#listUser");
$router->get('/Supprimer=:id', "User#deleteUser");
$router->get('/Ajouter-Utilisateur', "User#UserPage");
$router->post('/Liste-Utilisateurs', "User#addUser");

$router->get('/Gestion-Lieux', "Site#siteListe");
$router->get('Ajouter-Site','Site#sitePage');

$router->run(); 
