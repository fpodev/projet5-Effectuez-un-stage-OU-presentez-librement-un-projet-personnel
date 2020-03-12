<?php
namespace App\model;

use PDO;
use App\Objet\User;

class UserModel
{
    private $db;

    public function __construct(PDO $db)
    {
       $this->db = $db;
    }
    public function add(User $user)
    {
        $q = $this->db->prepare('INSERT INTO user(nom, prenom , email, lieu, niveau , userAdd) VALUES(:nom, :prenom, :email, :lieu, :niveau, :userAdd');
    
        $q->bindValue(':nom', $user->nom(),PDO::PARAM_STR);
        $q->bindValue(':prenom', $user->prenom(), PDO::PARAM_STR);
        $q->bindValue(':email', $user->email(), PDO::PARAM_STR);
        $q->bindValue(':lieu', $user->lieu(), PDO::PARAM_STR);
        $q->bindValue(':userAdd', $user->userAdd(), PDO::PARAM_STR);

        $q->execute();
    }
    public function delete($id)
    {
        $this->db->exec('DELETE FROM user WHERE id= '.(int)$id);
    }
    public function listUser()
    {
        $sql = 'SELECT * FROM user ORDER BY id DESC';

        $q = $this->db->query($sql);

        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'App\Objet\User');
    
        $userList = $q->fetchAll();

        $q->closeCursor();

        return $userList;
    }
    protected function update(User $user)
    {
        $q = $this->db->prepare('UPDATE user SET nom = :nom, email = :email, lieu = :lieu, niveau = :niveau, userModif = :userModif WHERE id = :id');

        $q->bindValue(':nom', $user->nom(), PDO::PARAM_STR);
        $q->bindValue(':email', $email->email(), PDO::PARAM_STR);
        $q->bindValue(':lieu', $user->lieu(), PDO::PARAM_STR );
        $q->bindValue(':niveau', $user->niveau(), PDO::PARAM_INT);
        $q->bindValue(':userModif', $user->userModif(),PDO::PARAM_STR);
        $q->bindValue(':id', $billet->id(), PDO::PARAM_INT);

        $q->execute();
    }
}