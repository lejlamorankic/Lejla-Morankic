<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/WorkoutsDao.php';

class WorkoutsService extends BaseService {

    public function __construct() {
        parent::__construct(new WorkoutsDao());
    }

    public function getByUserId($user_id): mixed {
        return $this->dao->getByUserId($user_id);
    }
}
?>
