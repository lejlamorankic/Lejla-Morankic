<?php
require_once __DIR__ . '/BaseDao.php';

class UserDao extends BaseDao {

    public function __construct() {
        parent::__construct('users');
    }

    public function add($user) {
        $this->insert($user);
        return $user;
    }

    public function getAllUsers() {
        return $this->getAll();
    }

    public function getById($id) {
        return parent::getById($id);
    }

   
    public function getByEmail($email) {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

  
    public function updateUser($id, $user) {
        $this->update($id, $user);
        return $user;
    }

 
    public function deleteUser($id) {
        $this->delete($id);
    }
}
