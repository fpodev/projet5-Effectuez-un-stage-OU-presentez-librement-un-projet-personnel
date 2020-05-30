<?php
/*
Author: fpodev (fpodev@gmx.fr)
index.php (c) 2020
Desc: Gestion des routes
Created:  2020-04-13T09:42:15.632Z
Modified: !date!
*/

use App\Routeur\Routeur;
require 'vendor/autoload.php';
session_cache_limiter('private, must-revalidate');
session_start();
$router = new Routeur($_GET['url']);

$router->get('/', "User#home"); 
$router->get('Accueil', 'User#home');
$router->post('Accueil', "User#connexion");
$router->get('Déconnexion',"User#Destroy");

$router->get('Gestion-Utilisateurs', "User#listUser");
$router->get('Supprimer-utilisateur=:id', "User#deleteUser");
$router->get('Ajouter-Utilisateur', "User#CreatePage");
$router->get('Changement-mot-de-passe', "User#changePage");
$router->post('Modification-mot-de-passe', "User#changePass");
$router->post('Utilisateur-ajouté', "User#addUser");
$router->get('Modifier=:id', "User#uniqueUser");
$router->post('Utilisateur-modifié', "User#updateUser");

$router->get('Gestion-Lieux', "Lieu#LieuList");
$router->get('supprimer-villes=:id', "Lieu#supprimeLieu");
$router->get('modifier-villes=:id', 'Lieu#uniqueLieu');
$router->post('modification-villes', "Lieu#updateLieu");
$router->post('Ajouter-villes', 'Lieu#addLieu');
$router->get('Villes=:id', 'Batiment#batimentList');

$router->get('Gestion-Batiments', 'Batiment#batimentList');
$router->get('supprimer-bâtiments=:id', 'Batiment#supprimeBatiment');
$router->post('modification-bâtiments', "Batiment#updateBatiment");
$router->get('modifier-bâtiments=:id', 'Batiment#uniqueBatiment');
$router->post('Ajouter-bâtiments', 'Batiment#addBatiment');
$router->get('Bâtiments=:id', 'Secteur#secteurList');

$router->get('supprimer-secteurs=:id', 'Secteur#supprimeSecteur');
$router->get('modifier-secteurs=:id', 'Secteur#uniqueSecteur');
$router->post('Ajouter-secteur', "Secteur#addSecteur");
$router->post('modification-secteurs', "Secteur#updateSecteur");
$router->get('Secteurs=:id', 'Materiel#materielList');


$router->get('supprimer-matériels=:id', 'Materiel#supprimeMateriel');
$router->post('Ajouter-matériels', "Materiel#addMateriel");
$router->post('modification-matériels', "Materiel#updateMateriel");
$router->get('modifier-matériels=:id', 'Materiel#uniqueMateriel');

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
