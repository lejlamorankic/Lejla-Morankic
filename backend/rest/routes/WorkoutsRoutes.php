<?php

require_once __DIR__ . '/../services/WorkoutsService.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../data/roles.php';


use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/workouts",
 *     tags={"workouts"},
 *     summary="Get all workouts",
 *     security={{"BearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of all workouts"
 *     )
 * )
 */
Flight::route('GET /workouts', function () {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::workouts_service()->getAll());
});

/**
 * @OA\Get(
 *     path="/workouts/{id}",
 *     tags={"workouts"},
 *     summary="Get workout by ID",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Workout ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Workout details"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Workout not found"
 *     )
 * )
 */
Flight::route('GET /workouts/@id', function ($id) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::workouts_service()->getById($id));
});

/**
 * @OA\Post(
 *     path="/workouts",
 *     tags={"workouts"},
 *     summary="Create new workout",
 *     security={{"BearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","category"},
 *             @OA\Property(property="name", type="string", example="Upper Body Strength"),
 *             @OA\Property(property="category", type="string", example="Upper Body"),
 *             @OA\Property(property="description", type="string", example="Push-ups, Rows, Shoulder Press")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Workout created successfully"
 *     )
 * )
 */
Flight::route('POST /workouts', function () {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);

    $data = json_decode(Flight::request()->getBody(), true);
    Flight::json(Flight::workouts_service()->add($data));
});

/**
 * @OA\Put(
 *     path="/workouts/{id}",
 *     tags={"workouts"},
 *     summary="Update workout",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Workout ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="category", type="string"),
 *             @OA\Property(property="description", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Workout updated successfully"
 *     )
 * )
 */
Flight::route('PUT /workouts/@id', function ($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);

    $data = json_decode(Flight::request()->getBody(), true);
    Flight::json(Flight::workouts_service()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/workouts/{id}",
 *     tags={"workouts"},
 *     summary="Delete workout",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Workout ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Workout deleted successfully"
 *     )
 * )
 */
Flight::route('DELETE /workouts/@id', function ($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::workouts_service()->delete($id));
});
