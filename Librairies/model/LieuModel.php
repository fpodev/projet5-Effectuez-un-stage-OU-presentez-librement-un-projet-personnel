<?php
/*
Author: fpodev (fpodev@gmx.fr)
LieuModel.php (c) 2020
Desc: bdd Lieu
Created:  2020-04-13T09:16:57.655Z
Modified: !date!
*/
namespace App\model;

use PDO;
use App\Objet\Lieu;
use RuntimeException;
class LieuModel{

    private $db;
   
    public function __construct(PDO $db)
    {
       $this->db = $db;
    }    
    public function add(Lieu $lieu)
    {
        $q = $this->db->prepare('INSERT INTO Lieu (ville) VALUES (:ville)');
    
        $q->bindValue(':ville', $lieu->nom(), PDO::PARAM_STR);         

        $q->execute();
    }
    public function delete($id)
    {
        $this->db->exec('DELETE FROM Lieu WHERE id= '.(int)$id);
    }
    public function lieuList()
    {
        $sql = 'SELECT * FROM Lieu';

        $q = $this->db->query($sql);

        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'App\Objet\Lieu');

        $lieuList = $q->fetchAll();

        $q->closeCursor();
        
        return $lieuList;
    }
    public function uniqueLieu($id)
    {
        $q = $this->db->prepare('SELECT * FROM Lieu WHERE id =:id');

        $q->bindValue(':id', $id, PDO::PARAM_INT);

        $q->execute();   
        
        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'App\Objet\Lieu');

        $lieu = $q->fetch();  

        $q->closeCursor();
       
        return $lieu; 
    }
    protected function update(Lieu $lieu)
    {
        $q = $this->db->prepare('UPDATE Lieu SET nom = :nom  WHERE id = :id');

        $q->bindValue(':nom', $lieu->nom(), PDO::PARAM_STR);          
        $q->bindValue(':id', $lieu->id(), PDO::PARAM_INT);

        $q->execute();
    }
    public function save(Lieu $lieu)
    {
        if ($lieu->isValid())
        {   
            $lieu->isNew() ? $this->add($lieu) : $this->update($lieu);
        }
        else
        {
            throw new RuntimeException('Le lieu doit être valide pour être enregistré');
        }
    } 
}