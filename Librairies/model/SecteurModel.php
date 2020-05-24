<?php
/*
Author: fpodev (fpodev@gmx.fr)
SecteurModel.php (c) 2020
Desc: Liaison avec la table Secteur de la Bdd.
Created:  2020-04-13T14:37:25.152Z
Modified: !date!
*/
namespace App\model;

use PDO;
use App\Objet\Secteur;
use RuntimeException;
class SecteurModel{

    private $db;
   
    public function __construct(PDO $db)
    {
       $this->db = $db;    }
    
    public function add(Secteur $secteur)
    {
        $q = $this->db->prepare('INSERT INTO Secteur (id_batiment, nom) VALUES (:id_batiment, :nom)');
    
        $q->bindValue(':id_batiment', $secteur->id_batiment(), PDO::PARAM_INT);  
        $q->bindValue(':nom', $secteur->nom(), PDO::PARAM_STR);         

        $q->execute();
    }
    public function delete($id)
    {
        $this->db->exec('DELETE FROM * WHERE id= '.(int)$id);
    }
    public function secteurList($id_batiment)
    {
        $q = $this->db->prepare('SELECT * FROM Secteur WHERE id_batiment = :id_batiment');

        $q->bindValue(':id_batiment', $id_batiment, PDO::PARAM_INT);

        $q->execute();

        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'App\Objet\Secteur');
    
        $secteurList = $q->fetchAll();

        $q->closeCursor();
        
        return $secteurList;
    }
    public function uniqueSecteur($id)
    {
        $q = $this->db->prepare('SELECT * FROM Secteur WHERE id =:id');

        $q->bindValue(':id', $id, PDO::PARAM_INT);
        $q->execute();   
        
        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'App\Objet\Secteur');

        $secteur = $q->fetch();  

        $q->closeCursor();
                
        return $secteur;
    }
    protected function update(Secteur $secteur)
    {
        $q = $this->db->prepare('UPDATE Secteur SET nom = :nom WHERE id = :id');

        $q->bindValue(':nom', $secteur->nom(), PDO::PARAM_STR);          
        $q->bindValue(':id', $secteur->id(), PDO::PARAM_INT);

        $q->execute();
    }
    public function save(Secteur $secteur)
    {
        if ($secteur->isValid() || $secteur->isValidUpdate())
        {   
            $secteur->isNew() ? $this->add($secteur) : $this->update($secteur);
        }
        else
        {
            throw new RuntimeException('Le lieu doit être valide pour être enregistré');
        }
    } 
}
