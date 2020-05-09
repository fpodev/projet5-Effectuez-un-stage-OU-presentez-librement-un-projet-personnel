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
$router->get('Accueil', 'User#home');
$router->post('Accueil', "User#connexion"); 

$router->get('Modifier=:id', "User#changeUser");
$router->get('Gestion-Utilisateurs', "User#listUser");
$router->get('Supprimer=:id', "User#deleteUser");
$router->get('Ajouter-Utilisateur', "User#UserPage");
$router->post('Liste-Utilisateurs', "User#addUser");

$router->get('Gestion-Lieux', "Lieu#LieuList");
$router->get('Ajouter-Site','Lieu#LieuPage');

$router->get('Villes=:id', 'Batiment#batimentList');
$router->get('Gestion-Batiments', 'Batiment#batimentList');

$router->get('Bâtiments=:id', 'Secteur#secteurList');
$router->get('Secteurs=:id', 'Materiel#materielList');

$router->get('Demande-Travaux', 'Travaux#travauxPage');
$router->get('Bâtiment=:id', 'Travaux#travauxPage');
$router->get('Secteur=:id','Travaux#travauxPage');
$router->get('Matériel=:id', 'Travaux#formulaireTravaux');
$router->post('Validation', 'Travaux#addTravaux');
$router->get('Liste-nouveaux-travaux', 'Travaux#travauxList');
$router->get('Liste-travaux-planifiés', 'Travaux#travauxList');
$router->get('Voir=:id', 'Travaux#uniqueTravaux');
$router->get('Planifier-travaux=:id', 'Travaux#uniqueTravaux');
$router->get('edit-travaux=:id', 'Travaux#uniqueTravaux');
$router->get('supprimer-travaux=:id', 'Travaux#deleteTravaux');
$router->post('Liste-nouveaux-travaux', 'Travaux#planifTravaux');

$router->get('apiGet', 'Api#api');
$router->get('Mes-travaux-planifiés', 'Travaux#travauxTech');

$router->run(); 
