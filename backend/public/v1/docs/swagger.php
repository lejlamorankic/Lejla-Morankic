<?php
// UGASI deprecated i notice poruke da ne prljaju output
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', 0);

require_once __DIR__ . '/../../../vendor/autoload.php';

header('Content-Type: application/json');

// PRAVA putanja do tvojih ruta
$openapi = \OpenApi\Generator::scan([
    __DIR__ . '/../../../rest/routes',
]);

echo $openapi->toJson();
