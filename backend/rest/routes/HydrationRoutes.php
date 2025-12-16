<?php

require_once __DIR__ . '/../services/HydrationService.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../data/roles.php';


use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/hydration",
 *     tags={"hydration"},
 *     summary="Get all hydration entries",
 *     security={{"BearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of all hydration entries"
 *     )
 * )
 */
Flight::route('GET /hydration', function () {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::hydration_service()->getAll());
});

/**
 * @OA\Get(
 *     path="/hydration/{id}",
 *     tags={"hydration"},
 *     summary="Get hydration entry by ID",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Hydration entry ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Hydration entry details"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Hydration entry not found"
 *     )
 * )
 */
Flight::route('GET /hydration/@id', function ($id) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::hydration_service()->getById($id));
});

/**
 * @OA\Post(
 *     path="/hydration",
 *     tags={"hydration"},
 *     summary="Create new hydration entry",
 *     security={{"BearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"amount", "date"},
 *             @OA\Property(property="amount", type="integer", example=500),
 *             @OA\Property(property="date", type="string", example="2025-01-10")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Hydration entry created successfully"
 *     )
 * )
 */
Flight::route('POST /hydration', function () {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);

    $data = json_decode(Flight::request()->getBody(), true);
    Flight::json(Flight::hydration_service()->add($data));
});

/**
 * @OA\Put(
 *     path="/hydration/{id}",
 *     tags={"hydration"},
 *     summary="Update hydration entry",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Hydration entry ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="amount", type="integer", example=750),
 *             @OA\Property(property="date", type="string", example="2025-01-11")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Hydration entry updated successfully"
 *     )
 * )
 */
Flight::route('PUT /hydration/@id', function ($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);

    $data = json_decode(Flight::request()->getBody(), true);
    Flight::json(Flight::hydration_service()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/hydration/{id}",
 *     tags={"hydration"},
 *     summary="Delete hydration entry",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Hydration entry ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Hydration entry deleted successfully"
 *     )
 * )
 */
Flight::route('DELETE /hydration/@id', function ($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::hydration_service()->delete($id));
});
