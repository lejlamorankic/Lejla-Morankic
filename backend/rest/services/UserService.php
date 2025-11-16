<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/UserDao.php';


class UserService extends BaseService {
    protected $dao;
    protected $connection;

    public function __construct() {
        parent::__construct(new UserDao());
    }


    public function get_user_by_id($id) {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE user_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            throw new Exception("User with ID {$id} not found.");
        }

        return $user;
    }

    public function get_users() {
        return $this->dao->getAllUsers();
    }

    public function add_user($data) {
        if (isset($data['email'])) {
            $existing = $this->dao->getByEmail($data['email']);
            if ($existing) {
                throw new Exception("User with email {$data['email']} already exists.");
            }
        }

        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        return $this->dao->add($data);
    }

    public function update_user($id, $data) {
        $existing = $this->get_user_by_id($id);
        if (!$existing) {
            throw new Exception("Cannot update: user with ID {$id} does not exist.");
        }

        return $this->dao->updateUser($id, $data);
    }

    public function partial_update_user($id, $data) {
        $existing = $this->get_user_by_id($id);
        if (!$existing) {
            throw new Exception("Cannot update: user with ID {$id} does not exist.");
        }

        return $this->dao->updateUser($id, $data);
    }

    public function delete_user($id) {
        $existing = $this->get_user_by_id($id);
        if (!$existing) {
            throw new Exception("Cannot delete: user with ID {$id} does not exist.");
        }

        return $this->dao->deleteUser($id);
    }

    public function get_user_by_email($email) {
        return $this->dao->getByEmail($email);
    }
}
?>
