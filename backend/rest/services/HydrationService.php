<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/HydrationDao.php';

class HydrationService extends BaseService {

    public function __construct() {
        parent::__construct(new HydrationDao());
    }

    public function getByUserId($user_id): mixed {
        return $this->dao->getByUserId($user_id);
    }

    public function getHydration($user_id): mixed {
        return $this->dao->getHydration($user_id);
    }

    public function getAll(): mixed {
        return $this->dao->getAll();
    }

    public function delete($id): void {
        $this->dao->delete($id);
    }
}
