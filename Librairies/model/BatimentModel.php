<?php
/*
Author: fpodev (fpodev@gmx.fr)
BatimentModel.php (c) 2020
Desc: Liaison avec la table Batiment de la Bdd.
Created:  2020-04-13T14:12:14.530Z
Modified: !date!
*/
namespace App\model;

use PDO;
use App\Objet\Batiment;
use RuntimeException;

class BatimentModel{

    private $db;
   
    public function __construct(PDO $db)
    {
       $this->db = $db;
    }
    
    public function add(Batiment $batiment)
    {
        $q = $this->db->prepare('INSERT INTO Batiment (id_lieu, nom) VALUES (:id_lieu, :nom)');
    
        $q->bindValue(':id_lieu', $batiment->id_lieu(), PDO::PARAM_INT);  
        $q->bindValue(':nom', $batiment->nom(), PDO::PARAM_STR);         

        $q->execute();
    }
    public function delete($id)
    {
        $this->db->exec('DELETE FROM Batiment WHERE id= '.(int)$id);
    }    
    public function BatimentList($id)
    {                 
        $q = $this->db->prepare('SELECT * FROM Batiment WHERE id_lieu = :id');
       
        $q->bindValue(':id', $id, PDO::PARAM_INT);

        $q->execute(); 

        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'App\Objet\Batiment');
    
        $batimentList = $q->fetchAll();

        $q->closeCursor();
       
        return $batimentList;
    }
    public function uniqueBatiment($id)
    {
        $q = $this->db->prepare('SELECT * FROM Batiment WHERE id =:id');

        $q->bindValue(':id', $id, PDO::PARAM_INT);
        
        $q->execute();   
        
        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'App\Objet\Batiment');

        $batiment= $q->fetch();  

        $q->closeCursor();
                
        return $batiment;
    }
    protected function update(Batiment $batiment)
    {
        $q = $this->db->prepare('UPDATE Batiment SET nom = :nom  WHERE id = :id');

        $q->bindValue(':nom', $batiment->nom(), PDO::PARAM_STR);          
        $q->bindValue(':id', $batiment->id(), PDO::PARAM_INT);

        $q->execute();
    }
    public function save(Batiment $batiment)
    {
        if ($batiment->isValid() || $batiment->isValidUpdate())
        {   
            $batiment->isNew() ? $this->add($batiment) : $this->update($batiment);
        }
        else
        {
            throw new RuntimeException('Le lieu doit être valide pour être enregistré');
        }
    } 
}