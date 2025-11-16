<?php
require_once __DIR__ . '/../dao/MotivationDao.php';
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/motivation",
 *     tags={"motivation"},
 *     summary="Get all motivation quotes",
 *     @OA\Response(
 *         response=200,
 *         description="List of all motivation quotes"
 *     )
 * )
 */
Flight::route('GET /motivation', function() {
    $dao = new MotivationDao();
    Flight::json($dao->getAll());
});

/**
 * @OA\Get(
 *     path="/motivation/{id}",
 *     tags={"motivation"},
 *     summary="Get single motivation quote by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Motivation ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Motivation quote data"
 *     )
 * )
 */
Flight::route('GET /motivation/@id', function($id) {
    $dao = new MotivationDao();
    Flight::json($dao->getById($id));
});

/**
 * @OA\Post(
 *     path="/motivation",
 *     tags={"motivation"},
 *     summary="Create new motivation quote",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"text"},
 *             @OA\Property(property="text", type="string", example="Believe in yourself!")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Motivation quote created"
 *     )
 * )
 */
Flight::route('POST /motivation', function() {
    $dao = new MotivationDao();
    $data = Flight::request()->data->getData();
    $id = $dao->insert($data);
    Flight::json(['id' => $id]);
});

/**
 * @OA\Put(
 *     path="/motivation/{id}",
 *     tags={"motivation"},
 *     summary="Update motivation quote",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Motivation ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="text", type="string", example="New updated quote")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Motivation quote updated"
 *     )
 * )
 */
Flight::route('PUT /motivation/@id', function($id) {
    $dao = new MotivationDao();
    $data = Flight::request()->data->getData();
    $dao->update($id, $data);
    Flight::json(['message' => 'Motivation updated successfully']);
});

/**
 * @OA\Delete(
 *     path="/motivation/{id}",
 *     tags={"motivation"},
 *     summary="Delete motivation quote",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Motivation ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Motivation quote deleted"
 *     )
 * )
 */
Flight::route('DELETE /motivation/@id', function($id) {
    $dao = new MotivationDao();
    $dao->delete($id);
    Flight::json(['message' => 'Motivation deleted successfully']);
});
