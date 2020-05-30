<?php
namespace App\model;
/*
Author: fpodev (fpodev@gmx.fr)
UserModel.php (c) 2020
Desc: Liaison avec la table User de la Bdd.
Created:  2020-04-13T14:03:28.788Z
Modified: !date!
*/
use PDO;
use App\Objet\User;
use RuntimeException;

class UserModel
{
    private $db;

    public function __construct(PDO $db)
    {
       $this->db = $db;
    }
    public function add(User $user)
    {
        $q = $this->db->prepare('INSERT INTO User (nom, prenom , email, pwd, id_lieu, niveau , userAdd, userModif) 
                                VALUES (:nom, :prenom, :email, :pwd, :id_lieu, :niveau, :userAdd, :userModif)');
    
        $q->bindValue(':nom', $user->nom(), PDO::PARAM_STR);
        $q->bindValue(':prenom', $user->prenom(), PDO::PARAM_STR);
        $q->bindValue(':email', $user->email(), PDO::PARAM_STR);
        $q->bindValue(':pwd', $user->pwd(), PDO::PARAM_STR);
        $q->bindValue(':id_lieu', $user->lieu(), PDO::PARAM_INT);
        $q->bindValue(':niveau', $user->niveau(), PDO::PARAM_INT);
        $q->bindValue(':userAdd', $user->userAdd(), PDO::PARAM_STR);
        $q->bindValue(':userModif', $user->userModif(), PDO::PARAM_STR);

        $q->execute();
    }
    public function delete($id)
    {
        $this->db->exec('DELETE FROM User WHERE id= '.(int)$id);
    }
    public function listUser()
    {   
        if($_SESSION['niveau'] == 0){
        $q = $this->db->prepare('SELECT User.id, User.nom, prenom, email, niveau, userAdd, Lieu.nom AS "lieu" FROM User 
                                INNER JOIN Lieu ON User.id_lieu = Lieu.id ORDER BY id DESC ');
        }
        else{//niveau 1
            $q = $this->db->prepare('SELECT User.id, User.nom, prenom, email, niveau, userAdd, Lieu.nom AS "lieu" FROM User 
                                    INNER JOIN Lieu ON User.id_lieu = Lieu.id WHERE User.id_Lieu = :id_lieu 
                                    AND NOT User.niveau = :niveau ORDER BY id DESC ');
             
       }             
         $q->bindValue(':niveau', "0",PDO::PARAM_INT);
         $q->bindValue(':id_lieu', $_SESSION['lieuId'],PDO::PARAM_INT);
         
        $q->execute();

        $q->setFetchMode(PDO::FETCH_ASSOC);
    
        $userList = $q->fetchAll();

        $q->closeCursor();

        return $userList;
    }    
    public function listTech($id)
     {              
        $q = $this->db->prepare('SELECT nom, prenom, id FROM User WHERE id_lieu = :id AND niveau = "2" ');

        $q->bindParam(':id',$id , PDO::PARAM_INT);

        $q->execute();

        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'App\Objet\User');
    
        $techList = $q->fetchAll();
        
        $q->closeCursor();

        return $techList;
    }
    public function uniqueUser($id)
    {
        $q = $this->db->prepare('SELECT * FROM User WHERE id =:id');

        $q->bindValue(':id', $id, PDO::PARAM_INT);
        
        $q->execute();   
        
        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'App\Objet\User');

        $user = $q->fetch();  

        $q->closeCursor();
                
        return $user;
    }
    protected function update(User $user)
    {
        $q = $this->db->prepare('UPDATE User SET nom = :nom, email = :email, id_lieu = :lieu, niveau = :niveau, userModif = :userModif WHERE id = :id');

        $q->bindValue(':nom', $user->nom(), PDO::PARAM_STR);
        $q->bindValue(':email', $user->email(), PDO::PARAM_STR);       
        $q->bindValue(':lieu', $user->lieu(), PDO::PARAM_INT );
        $q->bindValue(':niveau', $user->niveau(), PDO::PARAM_INT);
        $q->bindValue(':userModif', $user->userModif(),PDO::PARAM_STR);
        $q->bindValue(':id', $user->id(), PDO::PARAM_INT);

        $q->execute();
    }
    public function save(User $user)
    {
        if ($user->isValid())
        {   
            $user->isNew() ? $this->add($user) : $this->update($user);
        }
        else
        {
            throw new RuntimeException('L\'utilisateur doit être valide pour être enregistré');
        }
    }  

    public function connexion($identifiant)
    {
        $q = $this->db->prepare('SELECT * FROM User WHERE email = :identifiant');        
       
        $q->bindValue(':identifiant', $identifiant);              

        $q->execute(); 
        
        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'App\Objet\User');

        $resultat = $q->fetch();

        $q->closeCursor();

        return $resultat;         
    }    
    public function nouveauPass($identifiant, $passNew){
        
        $pass_hache = password_hash($passNew, PASSWORD_DEFAULT);
         
        $q = $this->db->prepare('UPDATE User SET pwd = :pass WHERE email = :identifiant');       
        
        $q->bindValue(':pass', $pass_hache);
        $q->bindValue(':identifiant', $identifiant);

        $q->execute();

    }   
}    
