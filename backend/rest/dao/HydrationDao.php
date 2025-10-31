<?php
require_once 'BaseDao.php';

class HydrationDao extends BaseDao {
    public function __construct() {
        parent::__construct("hydration");
    }

     public function get_by_id($id){
        return $this->getById($id);
    }


}
?>
