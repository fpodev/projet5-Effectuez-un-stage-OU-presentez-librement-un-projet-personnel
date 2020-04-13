<?php
/*
Author: fpodev (fpodev@gmx.fr)
TravauxModel.php (c) 2020
Desc: description
Created:  2020-04-13T15:10:34.230Z
Modified: !date!
*/

use PDO;
use App\Objet\Travaux;
use RuntimeException;

class SecteurModel{

    private $db;
   
    public function __construct(PDO $db)
    {
       $this->db = $db;    }
    
    public function add(Travaux $travaux)
    {
        $q = $this->db->prepare('INSERT INTO Travaux (id_materiel, description_demande, detail_demande, id_demandeur, urgence, id_technicien, date_demande, date_prevu, date_debut, date_fin, externe ) VALUES (:id_materiel, :description_demande, :detail, :id_demandeur, :urgence, :id_technicien, NOW(), :date_prevu, :date_debut, :date_fin, :externe');
    
        $q->bindValue(':id_materiel', $travaux->id_materiel(), PDO::PARAM_INT);  
        $q->bindValue(':description_demande', $travaux->description(), PDO::PARAM_STR); 
        $q->bindValue(':detail', $travaux->detail(), PDO::PARAM_STR);  
        $q->bindValue(':id_demandeur', $travaux->id_demandeur(), PDO::PARAM_INT); 
        $q->bindValue(':urgence', $travaux->urgence(), PDO::PARAM_INT);  
        $q->bindValue(':id_technicien', $travaux->id_technicien(), PDO::PARAM_INT);    
        $q->bindValue(':date_prevu', $travaux->date_prevu(), PDO::PARAM_INT);  
        $q->bindValue(':date_debut', $travaux->date_debut(), PDO::PARAM_INT);  
        $q->bindValue(':date_fin', $travaux->date_fin(), PDO::PARAM_INT);  
        $q->bindValue(':externe', $travaux->externe(), PDO::PARAM_STR);       

        $q->execute();
    }
    public function delete($id)
    {
        $this->db->exec('DELETE FROM Travaux WHERE id= '.(int)$id);
    }
    public function travauxList($id_materiel)
    {
        $q = $this->db->prepare = 'SELECT * FROM Travaux WHERE id_materiel = :id_materiel';

        $q->bindValue(':id_materiel', $id_materiel, PDO::PARAM_INT);

        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'App\Objet\Travaux');
    
        $travauxList = $q->fetchAll();

        $q->closeCursor();
        
        return $travauxList;
    }
    public function uniqueTravaux($id)
    {
        $q = $this->db->prepare('SELECT * FROM Travaux WHERE id =:id');

        $q->bindValue(':id', $id, PDO::PARAM_INT);
        $q->execute();   
        
        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'App\Objet\Batiment');

        $travaux = $q->fetch();  

        $q->closeCursor();
                
        return $travaux;
    }
    protected function update(Travaux $travaux)
    {
        $q = $this->db->prepare('UPDATE Travaux SET description_demande = :description_demande, detail_demande = :detail_demande  WHERE id = :id');

        $q->bindValue(':description_demande', $travaux->description_demande(), PDO::PARAM_STR); 
        $q->bindValue(':detail_demande', $travaux->detail_demande(), PDO::PARAM_STR) ;        
        $q->bindValue(':id', $travaux->id(), PDO::PARAM_INT);

        $q->execute();
    }
    public function save(Travaux $travaux)
    {
        if ($travaux->isValid())
        {   
            $travaux->isNew() ? $this->add($travaux) : $this->update($travaux);
        }
        else
        {
            throw new RuntimeException('Le lieu doit être valide pour être enregistré');
        }
    } 
}
