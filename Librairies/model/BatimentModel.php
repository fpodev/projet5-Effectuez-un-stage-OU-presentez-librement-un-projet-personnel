<?php
/*
Author: fpodev (fpodev@gmx.fr)
BatimentModel.php (c) 2020
Desc: bdd Batiment
Created:  2020-04-13T14:12:14.530Z
Modified: !date!
*/

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
        $q = $this->db->prepare('INSERT INTO Batiment (id_lieu, batiment) VALUES (:id_lieu, :batiment');
    
        $q->bindValue(':id_lieu', $batiment->id_lieu(), PDO::PARAM_INT);  
        $q->bindValue(':batiment', $batiment->batiment(), PDO::PARAM_STR);         

        $q->execute();
    }
    public function delete($id)
    {
        $this->db->exec('DELETE FROM Batiment WHERE id= '.(int)$id);
    }
    public function BatimentList($id_lieu)
    {
        $q = $this->db->prepare = 'SELECT batiment FROM Batiment WHERE id_lieu = :id_lieu';

        $q->bindValue(':id_lieu', $id_lieu, PDO::PARAM_INT);

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
        $q = $this->db->prepare('UPDATE Batiment SET batiment = :batiment  WHERE id = :id');

        $q->bindValue(':batiment', $batiment->batiment(), PDO::PARAM_STR);          
        $q->bindValue(':id', $batiment->id(), PDO::PARAM_INT);

        $q->execute();
    }
    public function save(Batiment $batiment)
    {
        if ($batiment->isValid())
        {   
            $batiment->isNew() ? $this->add($batiment) : $this->update($batiment);
        }
        else
        {
            throw new RuntimeException('Le lieu doit être valide pour être enregistré');
        }
    } 
}