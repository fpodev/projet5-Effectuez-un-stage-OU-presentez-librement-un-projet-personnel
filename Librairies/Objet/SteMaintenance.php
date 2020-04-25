<?php
/*
Author: fpodev (fpodev@gmx.fr)
SteMaintenance.php (c) 2020
Desc: Objet des sociétés de maintenance des différents actifs.
Created:  2020-04-17T11:47:29.147Z
Modified: !date!
*/
namespace App\Objet;

class SteMaintenance extends ExtendsObjet{

            private $adresse;
            private $tel;
            private $mail; 
            
            const ADRESSE_INVALIDE = 2;
            const TEL_INVALIDE = 3;
            const MAIL_INVALIDE = 4;

        public function isValid()
        {
            return !(empty($this->nom) || empty($this->adresse) || empty($this->tel) || empty($this->mail));
        }
}




