<?php
namespace App\Objet;
/*
Author: fpodev (fpodev@gmx.fr)
Lieu.php (c) 2020
Desc: Objet lieu n'ayant qu'une seule valeur, les contrôles ce font dans l'ExtendsObjet.
Created:  2020-04-13T14:03:28.788Z
Modified: !date!
*/
use App\Objet\ExtendsObjet;
class Lieu extends ExtendsObjet
{             
    public function isValid()
    {
        return !(empty($this->nom));
    }    
}

