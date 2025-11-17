<?php
require_once __DIR__ . '/../dao/MealsDao.php';
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/meals",
 *     tags={"meals"},
 *     summary="Get all meals",
 *     @OA\Response(
 *         response=200,
 *         description="List of all meals"
 *     )
 * )
 */
Flight::route('GET /meals', function() {
    $dao = new MealsDao();
    Flight::json($dao->getAll());
});

/**
 * @OA\Get(
 *     path="/meals/{id}",
 *     tags={"meals"},
 *     summary="Get a meal by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Meal ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Meal data"
 *     )
 * )
 */
Flight::route('GET /meals/@id', function($id) {
    $dao = new MealsDao();
    Flight::json($dao->getById($id));
});

/**
 * @OA\Post(
 *     path="/meals",
 *     tags={"meals"},
 *     summary="Create a new meal",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","calories"},
 *             @OA\Property(property="name", type="string", example="Chicken Salad"),
 *             @OA\Property(property="calories", type="integer", example=350),
 *             @OA\Property(property="protein", type="integer", example=30),
 *             @OA\Property(property="carbs", type="integer", example=10),
 *             @OA\Property(property="fat", type="integer", example=15)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="New meal created"
 *     )
 * )
 */
Flight::route('POST /meals', function() {
    $dao = new MealsDao();
    $data = Flight::request()->data->getData();
    $id = $dao->insert($data);
    Flight::json(['id' => $id]);
});

/**
 * @OA\Put(
 *     path="/meals/{id}",
 *     tags={"meals"},
 *     summary="Update a meal",
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
 *             @OA\Property(property="name", type="string", example="Updated Meal Name"),
 *             @OA\Property(property="calories", type="integer", example=450),
 *             @OA\Property(property="protein", type="integer", example=40),
 *             @OA\Property(property="carbs", type="integer", example=20),
 *             @OA\Property(property="fat", type="integer", example=10)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Meal updated"
 *     )
 * )
 */
Flight::route('PUT /meals/@id', function($id) {
    $dao = new MealsDao();
    $data = Flight::request()->data->getData();
    $dao->update($id, $data);
    Flight::json(['message' => 'Meal updated successfully']);
});

/**
 * @OA\Delete(
 *     path="/meals/{id}",
 *     tags={"meals"},
 *     summary="Delete a meal",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Meal ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Meal deleted"
 *     )
 * )
 */
Flight::route('DELETE /meals/@id', function($id) {
    $dao = new MealsDao();
    $dao->delete($id);
    Flight::json(['message' => 'Meal deleted successfully']);
});
