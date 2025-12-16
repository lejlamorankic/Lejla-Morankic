<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/MotivationDao.php';

class MotivationService extends BaseService {

    public function __construct() {
        parent::__construct(new MotivationDao());
    }

    public function getByUserId($user_id): mixed {
        return $this->dao->getByUserId($user_id);
    }
}

