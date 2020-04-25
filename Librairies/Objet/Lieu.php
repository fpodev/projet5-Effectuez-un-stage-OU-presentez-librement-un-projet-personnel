<?php
namespace App\Objet;

use App\Objet\ExtendsObjet;
class Lieu extends ExtendsObjet
{             
    public function isValid()
    {
        return !(empty($this->name));
    }    
}

