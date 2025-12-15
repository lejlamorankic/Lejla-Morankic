<?php

require_once __DIR__ . '/../services/UserService.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../data/roles.php';


use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/users",
 *     tags={"users"},
 *     summary="Get all users",
 *     security={{"BearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of all users"
 *     )
 * )
 */
Flight::route('GET /users', function () {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::user_service()->getAll());
});

/**
 * @OA\Get(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Get user by ID",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User details"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     )
 * )
 */
Flight::route('GET /users/@id', function ($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::user_service()->getById($id));
});

/**
 * @OA\Post(
 *     path="/users",
 *     tags={"users"},
 *     summary="Create new user",
 *     security={{"BearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","email","password","role"},
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john@gmail.com"),
 *             @OA\Property(property="password", type="string", example="password123"),
 *             @OA\Property(property="role", type="string", example="user")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User created successfully"
 *     )
 * )
 */
Flight::route('POST /users', function () {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);

    $data = json_decode(Flight::request()->getBody(), true);
    Flight::json(Flight::user_service()->add($data));
});

/**
 * @OA\Put(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Update existing user",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="role", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated successfully"
 *     )
 * )
 */
Flight::route('PUT /users/@id', function ($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);

    $data = json_decode(Flight::request()->getBody(), true);
    Flight::json(Flight::user_service()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Delete user by ID",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deleted successfully"
 *     )
 * )
 */
Flight::route('DELETE /users/@id', function ($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::user_service()->delete($id));
});
