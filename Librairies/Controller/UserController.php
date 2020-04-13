<?php
namespace App\Controller;


use App\Objet\User;
use App\View\Render;
use App\Mail\SendMail;
use App\model\UserModel;
use App\Objet\ConnexionDb;

class UserController{

        private $user;        
    
    public function __construct(){
        $db = ConnexionDb::getPDO();
        $this->user = new UserModel($db);  
        $this->send = new SendMail();   
        $this->render = new Render();    
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

                $prenom = $_POST['prenom'];
                $destinataire = $_POST['email'];
                $sujet = 'Création compte GMAO';
                ob_start();
                include ('Librairies/Mail/userView.php');
                $message = ob_get_clean();             
         
                $this->send->mail($destinataire, $sujet, $message);
                
                $this->listUser(); 
            }
            else
            {
                    $erreurs = $user->erreurs();                     
                
                    $this->render->view('CreateUser', ['user' => $erreurs]);                                                      
            } 
          
    }    
    public function listUser(){
            $userList = $this->user->listUser();                             
    
            $this->render->view('UserList', ['userList' => $userList]); 
    }
    
    public function changeUser($id){                
            if(preg_match("#[0-9]#" , $id))
            {
                $user = $this->user->uniqueUser($id);
                $this->render->view('CreateUser', ['user' => $user]); 
                            
            } 
            else{
                echo 'erreur 404';
            }           
    }
    public function userPage(){
            
            $this->render->view('CreateUser');          
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
                $this->render->view('Login.twig'); 
            }
            else
            {   
                $_SESSION['identifiant'] = $_POST['identifiant'];                
                $_SESSION['cookie'] = $_COOKIE;                          
                $_SESSION['prenom'] = $resultat['prenom'];
                $_SESSION['lieu'] = $resultat['lieu'];
                $_SESSION['niveau'] = $resultat['niveau'];

                $this->render->view('home'); 
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
                    
                       
                    include('Librairies/View/LoginView.php'); 
                }
                else
                {
                    echo 'Erreur confimation nouveau mot de pass'; 
                    include('Librairies/View/changePassView.php');
                }    
    }  
    public function home(){     
                  
            $this->render->view('home');   
                
        }       
}
