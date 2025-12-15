<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/rest/config.php';

header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/middleware/AuthMiddleware.php';

require_once __DIR__ . '/rest/services/BaseService.php';
require_once __DIR__ . '/rest/services/UserService.php';
require_once __DIR__ . '/rest/services/WorkoutsService.php';
require_once __DIR__ . '/rest/services/MealsService.php';
require_once __DIR__ . '/rest/services/HydrationService.php';
require_once __DIR__ . '/rest/services/MotivationService.php';
require_once __DIR__ . '/rest/services/AuthService.php';

Flight::register('base_service', 'BaseService');
Flight::register('user_service', 'UserService');
Flight::register('workouts_service', 'WorkoutsService');
Flight::register('meals_service', 'MealsService');
Flight::register('hydration_service', 'HydrationService');
Flight::register('motivation_service', 'MotivationService');
Flight::register('auth_service', 'AuthService');

Flight::register('auth_middleware', 'AuthMiddleware');

Flight::before('start', function () {

    $url = Flight::request()->url;

    if (
        str_starts_with($url, '/auth/login') ||
        str_starts_with($url, '/auth/register')
    ) {
        return TRUE;
    }

    $authHeader = Flight::request()->getHeader("Authorization");

    if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        Flight::halt(401, "Missing or invalid Authorization header");
    }

    $token = $matches[1];
    Flight::auth_middleware()->verifyToken($token);
});

Flight::map('error', function (Throwable $ex) {
    error_log("[" . date('Y-m-d H:i:s') . "] ERROR: " . $ex->getMessage());

    Flight::json([
        'success' => false,
        'message' => $ex->getMessage()
    ], 500);
});

Flight::before('start', function () {
    error_log("[" . date('Y-m-d H:i:s') . "] " . $_SERVER['REQUEST_METHOD'] . " " . $_SERVER['REQUEST_URI']);
});

require_once __DIR__ . '/rest/routes/AuthRoutes.php';
require_once __DIR__ . '/rest/routes/UserRoutes.php';
require_once __DIR__ . '/rest/routes/WorkoutsRoutes.php';
require_once __DIR__ . '/rest/routes/MealsRoutes.php';
require_once __DIR__ . '/rest/routes/HydrationRoutes.php';
require_once __DIR__ . '/rest/routes/MotivationRoutes.php';

Flight::start();
