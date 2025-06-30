<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function getUserIdFromJWT($jwt)
{
    try {
        $decoded = JWT::decode($jwt, new Key(env('JWT_SECRET'), 'HS256'));
        return $decoded->sub ?? null;
    } catch (Exception $e) {
        return null;
    }
}
