<?php
require_once 'BaseDao.php';

class WorkoutsDao extends BaseDao {
    public function __construct() {
        parent::__construct("workouts");
    }

     public function get_by_id($id){
        return $this->getById($id);
    }

}
?>
