<?php
use App\Routeur\Routeur;
require 'vendor/autoload.php';
session_start();
          
$router = new Routeur($_GET['url']);
$router->get('/', "User#home"); 
$router->get('/Accueil', 'User#home');
$router->get('/Modifier=:id', "User#changeUser");
$router->get('/Liste-Utilisateurs', "User#listUser");
$router->get('/Supprimer=:id', "User#deleteUser");
$router->get('/Ajouter-Utilisateur', "User#UserPage");
$router->post('/Accueil', "User#connexion"); 
$router->post('/Liste', "User#addUser");


$router->run(); 
