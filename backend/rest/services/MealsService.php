<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/MealsDao.php';

class MealsService extends BaseService {

    public function __construct() {
        parent::__construct(new MealsDao());
    }

    public function getByUserId($user_id): mixed {
        return $this->dao->getByUserId($user_id);
    }
}
?>
