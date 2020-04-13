<?php 
namespace App\Objet;

use PDO;

class ConnexionDb
{              
    public static function getPDO()
    {            
        $db = new PDO('mysql:host=localhost;dbname=GMAO;charset=utf8','', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);       
    
        return $db;
    }
}
