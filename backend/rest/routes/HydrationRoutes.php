<?php
require_once __DIR__ . '/../dao/HydrationDao.php';
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/hydration",
 *     tags={"hydration"},
 *     summary="Get all hydration records",
 *     @OA\Response(
 *         response=200,
 *         description="List of all hydration entries"
 *     )
 * )
 */
Flight::route('GET /hydration', function() {
    $dao = new HydrationDao();
    Flight::json($dao->getAll());
});

/**
 * @OA\Get(
 *     path="/hydration/{id}",
 *     tags={"hydration"},
 *     summary="Get a hydration entry by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Hydration ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Hydration entry data"
 *     )
 * )
 */
Flight::route('GET /hydration/@id', function($id) {
    $dao = new HydrationDao();
    Flight::json($dao->getById($id));
});

/**
 * @OA\Post(
 *     path="/hydration",
 *     tags={"hydration"},
 *     summary="Create a new hydration entry",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"amount", "user_id"},
 *             @OA\Property(property="amount", type="integer", example=500),
 *             @OA\Property(property="user_id", type="integer", example=3),
 *             @OA\Property(property="date", type="string", example="2025-01-29")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="New hydration entry created"
 *     )
 * )
 */
Flight::route('POST /hydration', function() {
    $dao = new HydrationDao();
    $data = Flight::request()->data->getData();
    $id = $dao->insert($data);
    Flight::json(['id' => $id]);
});

/**
 * @OA\Put(
 *     path="/hydration/{id}",
 *     tags={"hydration"},
 *     summary="Update a hydration entry",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Hydration ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=false,
 *         @OA\JsonContent(
 *             @OA\Property(property="amount", type="integer", example=750),
 *             @OA\Property(property="date", type="string", example="2025-02-01"),
 *             @OA\Property(property="user_id", type="integer", example=3)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Hydration entry updated"
 *     )
 * )
 */
Flight::route('PUT /hydration/@id', function($id) {
    $dao = new HydrationDao();
    $data = Flight::request()->data->getData();
    $dao->update($id, $data);
    Flight::json(['message' => 'Hydration entry updated successfully']);
});

/**
 * @OA\Delete(
 *     path="/hydration/{id}",
 *     tags={"hydration"},
 *     summary="Delete a hydration entry",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Hydration ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Hydration entry deleted"
 *     )
 * )
 */
Flight::route('DELETE /hydration/@id', function($id) {
    $dao = new HydrationDao();
    $dao->delete($id);
    Flight::json(['message' => 'Hydration entry deleted successfully']);
});
