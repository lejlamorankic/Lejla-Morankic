<?php
require_once 'BaseDao.php';

class MealsDao extends BaseDao {
    public function __construct() {
        parent::__construct("meals");
    }

     public function get_by_id($id){
        return $this->getById($id);
    }


}
?>



