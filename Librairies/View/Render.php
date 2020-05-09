<?php
namespace App\View;

use Twig\Environment;
use Twig\Extension\MyExtends;
use Twig\Loader\FilesystemLoader;
use Twig\Extra\Intl\IntlExtension;

class Render{

    public function __construct(){
        $this->loader = new \Twig\Loader\FilesystemLoader(['Librairies/View', 'Librairies/Templates']);
        $this->twig = new \Twig\Environment($this->loader,['debug' => true]); 
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        $this->twig->addExtension(new IntlExtension());        
    }
    public function view($vue, $value = null){        
        if(isset($_SESSION['identifiant']) && $_SESSION['cookie'] === $_COOKIE){                          

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
                 echo 'erreur 404';
             }              
        }
        else{ 
            session_destroy();                                            
            echo $this->twig->render('Login.twig');       
        }
    }
}
