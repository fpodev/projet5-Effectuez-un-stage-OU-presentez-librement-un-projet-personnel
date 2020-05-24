<?php
namespace App\Controller;
/*
Author: fpodev (fpodev@gmx.fr)
UserController.php (c) 2020
Desc: script de controle pour les utilisateurs
Created:  2020-05-24T14:03:14.857Z
Modified: !date!
*/
use App\Objet\User;
use App\Mail\SendMail;
use App\model\LieuModel;
use App\model\UserModel;
use App\model\TravauxModel;
use App\ConnexionBDD\ConnexionDb;
use App\Controller\VueController;

class UserController{

        private $user;  
        private $ville;
        private $travaux;      
    
    public function __construct(){
        $db = ConnexionDb::getPDO();
        $this->user = new UserModel($db);  
        $this->send = new SendMail();   
        $this->render = new VueController();  
        $this->ville = new LieuModel($db); 
        $this->travaux = new TravauxModel($db);
    }

    public function addUser(){ 
        //Création d'un mot de passe aléatoire.      
        $pass = substr(str_shuffle(
            'abcdefghijklmnopqrstuvwxyzABCEFGHIJKLMNOPQRSTUVWXYZ0123456789'),1, 10);
        
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        $lieu = htmlspecialchars($_POST['lieu']);
        $niveau = htmlspecialchars($_POST['niveau']);

        $user = new User(
            [
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'lieu' => $lieu,
                //hashe le mot de passe pour plus de sécurité                
                'pwd' => password_hash($pass, PASSWORD_DEFAULT),
                'niveau' => $niveau,
                'userAdd' => $_SESSION['identifiant'],
                'userModif' => $_SESSION['identifiant']              
            ]); 

        if($user->isValid())
        {
            $this->user->save($user);
            //envoie d'un mail au nouvel utilisateur pour lui indiqué sont identifiant et mot de passe.
            $prenom = $prenom;
            $destinataire = $email;
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
    public function updateUser() {

        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        $lieu = htmlspecialchars($_POST['lieu']);
        $niveau = htmlspecialchars($_POST['niveau']);

        $user = new User(
            [
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'lieu' => $lieu,                             
                'niveau' => $niveau,                
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

            $this->listUser(); 
        }
        else
        {
                $erreurs = $user->erreurs();                     
            
                $this->render->view('CreateUser', ['user' => $erreurs]);                                                      
        }           
    } 
    public function listUser(){
            $title = "utilisateurs";
            $userList = $this->user->listUser();                             
            $this->render->view('UserList', ['userList' => $userList, 'title' => $title]); 
    }    
    public function uniqueUser($id){  
        $user = $this->verif($id);
        if($user == true){            
            $title = "utilisateurs";
            $this->render->view('CreateUser', ['user' => $user, 'title' => $title]);  
        }     
    }   
    public function CreatePage(){ 
            $title = "utilisateur";           
            $this->render->view('CreateUser', ['title'=> $title]);          
    }
    public function deleteUser($id){
        $user = $this->verif($id);
        if($user == true){
            $this->user->delete($id);
            $this->listUser();
        }        
    }
    public function connexion(){ 
            $identifiant = htmlspecialchars($_POST['identifiant']); 
            $pass = htmlspecialchars($_POST['pass']);   

            $resultat = $this->user->connexion($identifiant);
                                        
            $okPass = password_verify($pass, $resultat['pwd']);        
            if(!$resultat || !$okPass)       
            {
                echo 'Mauvais identifiant ou mot de passe';
                $this->render->view('Login'); 
            }
            else
            {   
                $ville = $this->ville->uniqueLieu($resultat['id_lieu']);               

                $_SESSION['identifiant'] = $identifiant;             
                $_SESSION['cookie'] = $_COOKIE;                                      
                $_SESSION['prenom'] = $resultat['prenom'];
                $_SESSION['lieuId'] = $resultat['id_lieu'];
                $_SESSION['lieu'] = $ville->nom();
                $_SESSION['niveau'] = $resultat['niveau'];
                $_SESSION['id_user'] = $resultat['id'];                 
              
                $this->home(); 
            }
        }                                           
    public function changePass(){  
         $actuelPass = htmlspecialchars($_POST['passActuel']); 
         $passNew = htmlspecialchars($_POST['passNew']);
         $passConfirm = htmlspecialchars($_POST['passConfirm']);
         
            $resultat = $this->user->connexion($_SESSION["identifiant"]);

            $okPass = password_verify($actuelPass, $resultat['pwd']);        
                if(!$resultat || !$okPass)
                {
                    echo 'erreur ancien mot de passe';
                }
                elseif($passNew === $passConfirm)                     
                {               
                    $this->user->nouveauPass($_SESSION['identifiant']);                    
                    
                    session_destroy();
                    $this->render->view('home'); 
                }
                else
                {
                    echo 'Erreur confimation nouveau mot de pass'; 
                    include('Librairies/View/changePassView.php');
                }    
    }  
    public function home(){ 
       if(empty($_SESSION['niveau']) || $_SESSION['niveau'] != '2'){
            $userTvx = 'null';
       }           
        else
         {                  
        $userTvx = $this->travaux->countUser($_SESSION['id_user']); 
         };                        
          $countAll =  $this->travaux->countAll();
          $countPlanif = $this->travaux->countPlanif();             
          $countNew = $countAll - $countPlanif;                      
         
            $this->render->view('Home', ['countNew'=> $countNew, 'countPlanif' => $countPlanif, 'countUser' => $userTvx]);   
                
        } 
    public function changePage(){
        $this->render->view('ChangePass');
    } 
    public function Destroy(){
        session_destroy();
        $this->render->view('Login');
    } 
    /*verification que l'élement demandé via un $id est bien un nombre
    ** et existe bien dans la BDD avant de retourné ses valeurs*/
    public function Verif($id){    
        $idValid =  htmlspecialchars($id);                                           
        if (preg_match("#[0-9]#", $idValid))
        {
            $user = $this->user->uniqueUser($idValid);   
            if($user != false){
                return $user;       
            }
            else{
                $this->render->view('404');  
            }                        
        } 
        else{                             
            $this->render->view('404');                       
        }           
    }    
}
