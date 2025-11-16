<?php
require 'vendor/autoload.php';


require_once __DIR__ . '/rest/services/UserService.php';
require_once __DIR__ . '/rest/services/WorkoutsService.php';
require_once __DIR__ . '/rest/services/MealsService.php';
require_once __DIR__ . '/rest/services/HydrationService.php';
require_once __DIR__ . '/rest/services/MotivationService.php';
require_once __DIR__ . '/rest/services/BaseService.php';




Flight::route('/', function(){
    echo 'Hello World';
});


Flight::register('user_service', 'UserService');
Flight::register('workouts_service', 'WorkoutsService');
Flight::register('meals_service', 'MealsService');
Flight::register('hydrationService', 'HydrationService');
Flight::register('motivation_service', 'MotivationService');
Flight::register('baseService', 'BaseService');



require_once __DIR__ . '/rest/routes/UserRoutes.php';
require_once __DIR__ . '/rest/routes/WorkoutsRoutes.php';
require_once __DIR__ . '/rest/routes/MealsRoutes.php';
require_once __DIR__ . '/rest/routes/HydrationRoutes.php';
require_once __DIR__ . '/rest/routes/MotivationRoutes.php';
//require_once __DIR__ . '/rest/routes/BaseRoutes.php';

Flight::start();
