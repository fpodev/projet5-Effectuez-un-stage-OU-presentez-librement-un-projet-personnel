<?php

use Twig\Environment;
use App\Controller\UserControler;
use Twig\Loader\FilesystemLoader;

session_start();
require 'vendor/autoload.php';

/*$loader = new \Twig\Loader\FilesystemLoader('Librairies/View');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
]);*/
//HjgkRywEIB
class routeur{

         private $ctrlUser;
         private $loader;
         private $twig;

    public function __construct()
    {
        $this->ctrlUser = new UserControler();
        $this->loader = new \Twig\Loader\FilesystemLoader(['Librairies/View', 'Librairies/Templates']);
        $this->twig = new \Twig\Environment($this->loader);    
    }
    public function connect()   
    {                            
        if(isset($_GET['connexion']))
            { 
              //si une session existe ce connect directement
              if(!empty($_SESSION['user']) && $_SESSION['user'] === $_COOKIE)
              {
                $this->ctrlUser->listUser();                             
              }
              //si session non existante, detruit la session dans le cache et renvoie sur la page pour se connecter
              else{ 
                session_destroy();                 
                include ('Librairies/View/Login.php');   
              }
            } 
        
        elseif(isset($_POST['connexion']))       
        {            
            $this->ctrlUser->connexion();              
        }    
        elseif(isset($_POST['valider']))
        {           
            $this->ctrlUser->addUser();
        }
        elseif(isset($_GET['modifier']))
        {
            $this->ctrlUser->changeUser();
        }
        elseif(isset($_GET['deleteUser']))
        {
            $this->ctrlUser->deleteUser();
        }
        else
        {
          echo $this->twig->render('Login.twig');       
        }
}
}