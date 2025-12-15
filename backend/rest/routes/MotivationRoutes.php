<?php

require_once __DIR__ . '/../services/MotivationService.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../data/roles.php';


use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/motivation",
 *     tags={"motivation"},
 *     summary="Get all motivation quotes",
 *     security={{"BearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of all motivation quotes"
 *     )
 * )
 */
Flight::route('GET /motivation', function () {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::motivation_service()->getAll());
});

/**
 * @OA\Get(
 *     path="/motivation/{id}",
 *     tags={"motivation"},
 *     summary="Get motivation quote by ID",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Motivation quote ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Motivation quote details"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Motivation quote not found"
 *     )
 * )
 */
Flight::route('GET /motivation/@id', function ($id) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::motivation_service()->getById($id));
});

/**
 * @OA\Post(
 *     path="/motivation",
 *     tags={"motivation"},
 *     summary="Create new motivation quote",
 *     security={{"BearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"quote"},
 *             @OA\Property(property="quote", type="string", example="The only bad workout is the one that didn't happen."),
 *             @OA\Property(property="author", type="string", example="Unknown")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Motivation quote created successfully"
 *     )
 * )
 */
Flight::route('POST /motivation', function () {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);

    $data = json_decode(Flight::request()->getBody(), true);
    Flight::json(Flight::motivation_service()->add($data));
});

/**
 * @OA\Put(
 *     path="/motivation/{id}",
 *     tags={"motivation"},
 *     summary="Update motivation quote",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Motivation quote ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="quote", type="string", example="Updated quote"),
 *             @OA\Property(property="author", type="string", example="Updated author")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Motivation quote updated successfully"
 *     )
 * )
 */
Flight::route('PUT /motivation/@id', function ($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);

    $data = json_decode(Flight::request()->getBody(), true);
    Flight::json(Flight::motivation_service()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/motivation/{id}",
 *     tags={"motivation"},
 *     summary="Delete motivation quote",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Motivation quote ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Motivation quote deleted successfully"
 *     )
 * )
 */
Flight::route('DELETE /motivation/@id', function ($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::motivation_service()->delete($id));
});
