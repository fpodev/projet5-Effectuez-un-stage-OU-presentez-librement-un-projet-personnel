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
$router->get('Batiment=:id', 'Travaux#travauxPage');
$router->get('Secteur=:id','Travaux#travauxPage');
$router->get('Matériel=:id', 'Travaux#formulaireTravaux');
$router->post('Validation', 'Travaux#addTravaux');
$router->get('Liste-nouveaux-travaux', 'Travaux#TravauxList');
$router->get('Planifier-travaux=:id', 'Travaux#uniqueTravaux');
$router->post('Planification-valide', 'Travaux#addTravaux');


$router->run(); 
