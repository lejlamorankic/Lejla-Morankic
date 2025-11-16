<?php
require_once 'BaseDao.php';

class HydrationDao extends BaseDao {
    public function __construct() {
        parent::__construct("hydration");
    }

    public function getAll(){
        return $this->getAll();
    
    }
    public function delete($id) {
        return $this->delete($id);
    }


}
?>
