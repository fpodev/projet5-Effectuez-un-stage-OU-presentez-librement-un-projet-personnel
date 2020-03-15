<?php
namespace App\Controller;

use App\model\UserModel;
use App\Objet\ConnexionDb;

class UserControler{

        private $user;
    
    public function __construct(){
        $db = ConnexionDb::getPDO();
        $this->user = new UserModel($db);
    }

    public function addUser(){
        $pass = substr(str_shuffle(
            'abcdefghijklmnopqrstuvwxyzABCEFGHIJKLMNOPQRSTUVWXYZ0123456789'),1, 10); 
            
        $user = new User(
            [
                'nom' => $_POST('nom'),
                'prenom' => $_POST('prenom'),
                'email' => $_POST('email'),
                'lieu' => $_POST('lieu'),
                'password' => $pass,
                
            ]
            );
       
    }
    
    public function listUser(){

    }
    
    public function ChangeUser(){

    }
    public function deleteUser(){

    }
}