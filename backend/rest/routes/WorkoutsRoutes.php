<?php
require_once __DIR__ . '/../dao/WorkoutsDao.php';
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/workouts",
 *     tags={"workouts"},
 *     summary="Get all workouts",
 *     @OA\Response(
 *         response=200,
 *         description="List of all workouts"
 *     )
 * )
 */
Flight::route('GET /workouts', function() {
    $dao = new WorkoutsDao();
    Flight::json($dao->getAll());
});

/**
 * @OA\Get(
 *     path="/workouts/{id}",
 *     tags={"workouts"},
 *     summary="Get workout by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Workout ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Workout data"
 *     )
 * )
 */
Flight::route('GET /workouts/@id', function($id) {
    $dao = new WorkoutsDao();
    Flight::json($dao->getById($id));
});

/**
 * @OA\Post(
 *     path="/workouts",
 *     tags={"workouts"},
 *     summary="Create a new workout",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","duration","intensity"},
 *             @OA\Property(property="name", type="string", example="Cardio Blast"),
 *             @OA\Property(property="duration", type="integer", example=45),
 *             @OA\Property(property="intensity", type="string", example="High")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Workout created"
 *     )
 * )
 */
Flight::route('POST /workouts', function() {
    $dao = new WorkoutsDao();
    $data = Flight::request()->data->getData();
    $id = $dao->insert($data);
    Flight::json(['id' => $id]);
});

/**
 * @OA\Put(
 *     path="/workouts/{id}",
 *     tags={"workouts"},
 *     summary="Update a workout",
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
 *             @OA\Property(property="name", type="string", example="Updated Workout"),
 *             @OA\Property(property="duration", type="integer", example=60),
 *             @OA\Property(property="intensity", type="string", example="Medium")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Workout updated"
 *     )
 * )
 */
Flight::route('PUT /workouts/@id', function($id) {
    $dao = new WorkoutsDao();
    $data = Flight::request()->data->getData();
    $dao->update($id, $data);
    Flight::json(['message' => 'Workout updated successfully']);
});

/**
 * @OA\Delete(
 *     path="/workouts/{id}",
 *     tags={"workouts"},
 *     summary="Delete a workout",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Workout ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Workout deleted"
 *     )
 * )
 */
Flight::route('DELETE /workouts/@id', function($id) {
    $dao = new WorkoutsDao();
    $dao->delete($id);
    Flight::json(['message' => 'Workout deleted successfully']);
});
