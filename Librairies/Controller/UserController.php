<?php
namespace App\Controller;

use App\Objet\User;
use App\model\UserModel;
use App\model\ViewModel;
use App\Objet\ConnexionDb;

class UserController{

        private $user;        
    
    public function __construct(){
        $db = ConnexionDb::getPDO();
        $this->user = new UserModel($db);        
        
        $this->loader = new \Twig\Loader\FilesystemLoader(['Librairies/View', 'Librairies/Templates']);
        $this->twig = new \Twig\Environment($this->loader); 
    }

    public function addUser(){       
        $pass = substr(str_shuffle(
            'abcdefghijklmnopqrstuvwxyzABCEFGHIJKLMNOPQRSTUVWXYZ0123456789'),1, 10); 
         
        $user = new User(
            [
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'email' => $_POST['email'],
                'lieu' => $_POST['lieu'],                
                'pwd' => password_hash($pass, PASSWORD_DEFAULT),
                'niveau' => $_POST['niveau'],
                'userAdd' => $_SESSION['identifiant'],
                'userModif' => $_SESSION['identifiant']              
            ]
            );
            if(isset($_POST['id']))
            {
                $user->setId($_POST['id']);
            }
            if($user->isValid())
            {
                $this->user->save($user);
            }
            else
            {
                    $erreurs = $user->erreurs();                                                        
            } 
            $this->listUser(); 
    }    
    public function listUser(){
        $userList = $this->user->listUser();

        echo $this->twig->render('UserList.twig', array('userList' => $userList));
    }
    
    public function changeUser($id){                
            if(preg_match("#[0-9]#" , $id))
            {
                   $user = $this->user->uniqueUser($id);
                   echo $this->twig->render('CreateUser.twig', array('user' => $user));                  
            }            
    }
    public function userPage(){
        echo $this->twig->render('CreateUser.twig');
    }
    public function deleteUser($id){
            $this->user->delete($id);
            $this->listUser();
    }
    public function connexion(){ 
                      
        $resultat = $this->user->connexion(($_POST['identifiant']));
                                              
        $okPass = password_verify($_POST['pass'], $resultat['pwd']);        
            if(!$resultat || !$okPass)       
            {
                echo 'Mauvais identifiant ou mot de passe';
                echo $this->twig->render('Login.twig'); 
            }
            else
            {                                                                                                      
                $_SESSION['identifiant'] = $_POST['identifiant'];                
                $_SESSION['user'] = $_COOKIE;
                $_SESSION['niveau'] = $resultat['niveau'];
                $_SESSION['identitie'] = $resultat['prenom'];
               
                echo $this->twig->render('home.twig', ['niveau' => $_SESSION['niveau']]);                                                                                                                                                                                                                       
            }
        }                                           
    public function ChangePass(){                                        
            $resultat = $this->mLogin->connexion($_SESSION["identifiant"]);                                                
            $okPass = password_verify($_POST['pass1'], $resultat['pass']);        
                if(!$resultat || !$okPass)
                {
                    echo 'erreur ancien mot de passe';
                }
                elseif($_POST['pass2'] === $_POST['pass3'])                     
                {               
                    $this->user->nouveauPass($_SESSION['identifiant']);
                    
                    session_destroy();    
                    include('Librairies/View/LoginView.php'); 
                }
                else
                {
                    echo 'Erreur confimation nouveau mot de pass'; 
                    include('Librairies/View/changePassView.php');
                }    
    }  
    public function home(){ 
        if(!empty($_SESSION['user']) && $_SESSION['user'] === $_COOKIE){
            echo $this->twig->render('home.twig');
        }
        else{                                   
        echo $this->twig->render('Login.twig');        
        }
    }  
}