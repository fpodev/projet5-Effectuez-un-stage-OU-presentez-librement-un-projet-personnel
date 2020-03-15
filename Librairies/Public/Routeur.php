<?php

use App\Controller\UserControler;
require 'vendor/autoload.php';

/*$loader = new \Twig\Loader\FilesystemLoader('Librairies/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => 'Librairies/compilation_cache',
]);*/

class routeur{

         private $ctrlUser;

    public function __construct(){
        $this->ctrlUser = new UserControler();
    }
    public function connect()
    {
        include ('Librairies/View/CreateUser.php');
    }
}