<?php
/*
Author: fpodev (fpodev@gmx.fr)
MaterielModel.php (c) 2020
Desc: description
Created:  2020-04-13T15:12:55.132Z
Modified: !date!
*/

use PDO;
use App\Objet\Materiel;
use RuntimeException;

class MaterielModel{

    private $db;
   
    public function __construct(PDO $db)
    {
       $this->db = $db;    }
    
    public function add(Materiel $materiel)
    {
        $q = $this->db->prepare('INSERT INTO Materiel (id_lieu, id_batiment, id_secteur, materiel) VALUES (:id_lieu, :id_batiment :id_secteur, :materiel');
    
        $q->bindValue(':id_lieu', $materiel->id_lieu(), PDO::PARAM_INT);  
        $q->bindValue(':id_batiment', $materiel->id_batiment(), PDO::PARAM_INT);  
        $q->bindValue(':id_secteur', $materiel->id_secteur(), PDO::PARAM_INT);  
        $q->bindValue(':materiel', $materiel->materiel(), PDO::PARAM_STR);         

        $q->execute();
    }
    public function delete($id)
    {
        $this->db->exec('DELETE FROM Materiel WHERE id= '.(int)$id);
    }
    public function MaterielList($id_secteur)
    {
        $q = $this->db->prepare = 'SELECT materiel FROM Materiel WHERE id_secteur = :id_secteur';

        $q->bindValue(':id_secteur', $id_secteur, PDO::PARAM_INT);

        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'App\Objet\Materiel');
    
        $MaterielList = $q->fetchAll();

        $q->closeCursor();
        
        return $MaterielList;
    }
    public function uniqueMateriel($id)
    {
        $q = $this->db->prepare('SELECT * FROM Materiel WHERE id =:id');

        $q->bindValue(':id', $id, PDO::PARAM_INT);
        $q->execute();   
        
        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'App\Objet\Materiel');

        $materiel = $q->fetch();  

        $q->closeCursor();
                
        return $materiel;
    }
    protected function update(Materiel $materiel)
    {
        $q = $this->db->prepare('UPDATE Materiel SET materiel = :materiel WHERE id = :id');

        $q->bindValue(':materiel', $materiel->materiel(), PDO::PARAM_STR);          
        $q->bindValue(':id', $materiel->id(), PDO::PARAM_INT);

        $q->execute();
    }
    public function save(Materiel $materiel)
    {
        if ($materiel->isValid())
        {   
            $materiel->isNew() ? $this->add($materiel) : $this->update($materiel);
        }
        else
        {
            throw new RuntimeException('Le lieu doit être valide pour être enregistré');
        }
    } 
}
