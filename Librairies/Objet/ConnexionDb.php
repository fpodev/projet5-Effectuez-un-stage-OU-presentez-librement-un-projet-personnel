<?php 
namespace App\Objet;

use PDO;

class ConnexionDb
{
    private $host = 'localhost';
    private $dbName = 'GMAO';
    private $user = 'fabrice';
    private $pwd = 'Frbrl7C90848467';    

    public static function getPDO()
    {
        $db = new PDO("mysql:host=$host;dbname=$dbName; charset=utf8", $user , $pwd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

        return $db;       
    }
}
