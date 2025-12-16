<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/AuthDao.php';

use Firebase\JWT\JWT;

class AuthService extends BaseService {

    private $auth_dao;

    public function __construct() {
        $this->auth_dao = new AuthDao();
        parent::__construct(new AuthDao());
    }

    public function get_user_by_email($email) {
        return $this->auth_dao->get_user_by_email($email);
    }

    public function register($entity) {

        if (empty($entity['name']) || empty($entity['email']) || empty($entity['password'])) {
            return ['success' => false, 'error' => 'Name, email, and password are required'];
        }

        $existing_user = $this->auth_dao->get_user_by_email($entity['email']);
        if ($existing_user) {
            return ['success' => false, 'error' => 'Email already registered'];
        }

        $entity['password'] = password_hash($entity['password'], PASSWORD_BCRYPT);

        if (empty($entity['role'])) {
            $entity['role'] = 'user';
        }

        $user = parent::add($entity);
        unset($user['password']);

        return [
            'success' => true,
            'data' => $user
        ];
    }

    public function login($entity) {

        if (empty($entity['email']) || empty($entity['password'])) {
            return ['success' => false, 'error' => 'Email and password are required'];
        }

        $user = $this->auth_dao->get_user_by_email($entity['email']);

        if (!$user || !password_verify($entity['password'], $user['password'])) {
            return ['success' => false, 'error' => 'Invalid email or password'];
        }

        unset($user['password']);

        $payload = [
            'user' => $user,
            'iat' => time(),
            'exp' => time() + (60 * 60 * 24) 
        ];

        $token = JWT::encode($payload, Config::JWT_SECRET(), 'HS256');

        return [
            'success' => true,
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ];
    }
}
