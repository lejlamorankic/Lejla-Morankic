<?php
require_once 'BaseDao.php';

class MealsDao extends BaseDao {
    public function __construct() {
        parent::__construct("meals");
    }

     public function getByUserId($user_id): mixed {
        return $this->getByColumn('user_id', $user_id);
    }


}
?>



