<?php

require_once __DIR__ . '/../services/MealsService.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../data/roles.php';


use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/meals",
 *     tags={"meals"},
 *     summary="Get all meals",
 *     security={{"BearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of all meals"
 *     )
 * )
 */
Flight::route('GET /meals', function () {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::meals_service()->getAll());
});

/**
 * @OA\Get(
 *     path="/meals/{id}",
 *     tags={"meals"},
 *     summary="Get meal by ID",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Meal ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Meal details"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Meal not found"
 *     )
 * )
 */
Flight::route('GET /meals/@id', function ($id) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::meals_service()->getById($id));
});

/**
 * @OA\Post(
 *     path="/meals",
 *     tags={"meals"},
 *     summary="Create new meal",
 *     security={{"BearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","calories"},
 *             @OA\Property(property="name", type="string", example="Grilled Chicken Salad"),
 *             @OA\Property(property="calories", type="integer", example=420),
 *             @OA\Property(property="description", type="string", example="Healthy meal")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Meal created successfully"
 *     )
 * )
 */
Flight::route('POST /meals', function () {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);

    $data = json_decode(Flight::request()->getBody(), true);
    Flight::json(Flight::meals_service()->add($data));
});

/**
 * @OA\Put(
 *     path="/meals/{id}",
 *     tags={"meals"},
 *     summary="Update meal",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Meal ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Updated Meal"),
 *             @OA\Property(property="calories", type="integer", example=500),
 *             @OA\Property(property="description", type="string", example="Updated description")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Meal updated successfully"
 *     )
 * )
 */
Flight::route('PUT /meals/@id', function ($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);

    $data = json_decode(Flight::request()->getBody(), true);
    Flight::json(Flight::meals_service()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/meals/{id}",
 *     tags={"meals"},
 *     summary="Delete meal",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Meal ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Meal deleted successfully"
 *     )
 * )
 */
Flight::route('DELETE /meals/@id', function ($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::meals_service()->delete($id));
});
