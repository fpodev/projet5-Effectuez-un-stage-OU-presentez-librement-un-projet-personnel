<?php
namespace App\Controller;
/*
Author: fpodev (fpodev@gmx.fr)
VueController.php (c) 2020
Desc: Script de contrôle des vues avant affichage
Created:  2020-05-24T13:59:04.044Z
Modified: !date!
*/
use Twig\Environment;
use Twig\Extension\MyExtends;
use Twig\Loader\FilesystemLoader;
use Twig\Extra\Intl\IntlExtension;

class VueController{

    public function __construct(){
        $this->loader = new \Twig\Loader\FilesystemLoader(['Librairies/View', 'Librairies/Templates']);
        $this->twig = new \Twig\Environment($this->loader,['debug' => true]); 
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        $this->twig->addExtension(new IntlExtension());        
    }
    public function view($vue, $value = null){   
        /*verifie qu'une session est bien ouverte sinon envoie sur la page login */     
        if(isset($_SESSION['identifiant']) && $_SESSION['cookie'] === $_COOKIE){                          
            /*verifie que le fichier de la vue demandé existe sinon envoie erreur 404 */
            if(file_exists('Librairies/View/'.$vue.'.twig')){

                $this->twig->addGlobal('session' , $_SESSION);                
                
                if($value == null){
                    echo $this->twig->render(''.$vue.'.twig');
                }
                else{  
                    $this->twig->addGlobal('count', $value);                                                                                              
                    echo $this->twig->render(''.$vue.'.twig', $value);  
                }                        
             }
             else{
                echo $this->twig->render('404.twig');  
             }              
        }
        else{ 
            session_destroy();                                            
            echo $this->twig->render('Login.twig');       
        }
    }
}
