<?php
require_once 'BaseDao.php';

class WorkoutsDao extends BaseDao {
    public function __construct() {
        parent::__construct("workouts");
    }

      public function getById($id) {
        return parent::getById($id);
    }
}
?>
