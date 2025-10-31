<?php
require_once 'BaseDao.php';

class MotivationDao extends BaseDao {
    public function __construct() {
        parent::__construct("motivation");
    }

     public function get_by_id($id){
        return $this->getById($id);
    }


}
?>
