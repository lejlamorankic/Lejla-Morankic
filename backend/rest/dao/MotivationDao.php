<?php
require_once 'BaseDao.php';

class MotivationDao extends BaseDao {
    public function __construct() {
        parent::__construct("motivation");
    }

     public function getByUserId($user_id): mixed {
        return $this->getByColumn('user_id', $user_id);
    }


}
?>
