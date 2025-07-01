<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Token tidak ditemukan'], 401);
        }

        try {
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

            // Tambahkan info user ke request
            $request->merge([
                'user_id' => $decoded->sub,
                'email' => $decoded->email ?? null,
                'role' => $decoded->role ?? 'user', // jika tidak ada, default ke user
            ]);

            // Jika kamu punya model User:
            // $user = \App\Models\User::find($decoded->sub);
            // if (!$user) return response()->json(['error' => 'User tidak ditemukan'], 401);
            // $request->setUserResolver(fn () => $user);

            return $next($request);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Token tidak valid',
                'detail' => $e->getMessage()
            ], 401);
        }
    }
}
