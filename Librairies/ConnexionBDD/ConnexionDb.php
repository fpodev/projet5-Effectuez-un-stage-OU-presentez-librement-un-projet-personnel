<?php 
namespace App\ConnexionBDD;
/*
Author: fpodev (fpodev@gmx.fr)
ConnexionDb.php (c) 2020
Desc: Gére la connexion à la base de donnée
Created:  2020-04-13T14:03:28.788Z
Modified: !date!
*/
use PDO;

class ConnexionDb
{              
    public static function getPDO()
    {            
        $db = new PDO('mysql:host=localhost;dbname=GMAO;charset=utf8','fabrice', 'Frbrl7C90848467');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);       
    
        return $db;
    }
}
