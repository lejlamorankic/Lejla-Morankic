<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::group('/auth', function () {

    /**
     * @OA\Post(
     *     path="/auth/register",
     *     summary="Register new user",
     *     tags={"auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="role", type="string", example="user")
     *         )
     *     ),
     *     @OA\Response(response=200, description="User registered")
     * )
     */
    Flight::route('POST /register', function () {

        $data = json_decode(Flight::request()->getBody(), true);

        if (!is_array($data)) {
            Flight::halt(400, 'Invalid request payload');
        }

        $response = Flight::auth_service()->register($data);

        if ($response['success']) {
            Flight::json([
                'success' => true,
                'data' => $response['data']
            ]);
        } else {
            Flight::halt(500, $response['error']);
        }
    });

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     tags={"auth"},
     *     summary="Login user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="JWT token")
     * )
     */
    Flight::route('POST /login', function () {

        $data = json_decode(Flight::request()->getBody(), true);

        if (!is_array($data)) {
            Flight::halt(400, 'Invalid request payload');
        }

        $response = Flight::auth_service()->login($data);

        if ($response['success']) {
            Flight::json([
                'success' => true,
                'data' => $response['data']
            ]);
        } else {
            Flight::halt(401, $response['error']);
        }
    });
});
