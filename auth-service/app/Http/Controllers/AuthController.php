<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $validated['password'] = Hash::make($validated['password']); // ✅ manual hash
        $validated['role'] = $request->input('role', 'user');

        $user = User::create($validated);

        return response()->json([
            'message' => 'Registrasi berhasil',
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        $payload = [
            'sub' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'iat' => time(),
            'exp' => time() + (60 * 60), // 1 jam
        ];

        $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
        ]);
    }

    public function me(Request $request)
    {
        // Ambil token dari header Authorization
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Token tidak ditemukan'], 401);
        }

        try {
            // Dekode token untuk mendapatkan payload
            $decoded = JWT::decode($token, env('JWT_SECRET'), ['HS256']);

            // Ambil user ID dari token
            $userId = $decoded->sub;

            // Ambil data user berdasarkan ID
            $user = User::find($userId);

            if (!$user) {
                return response()->json(['message' => 'User tidak ditemukan'], 404);
            }

            // Kembalikan data user (misalnya nama dan email)
            return response()->json([
                'name' => $user->name,
                'email' => $user->email,
            ]);
        } catch (\Exception $e) {
            // Log error jika token tidak valid
            \Log::error('Token decoding error: ' . $e->getMessage());
            return response()->json(['message' => 'Token tidak valid'], 401);
        }
    }

    public function logout(Request $request)
    {
        return response()->json(['message' => 'Logout berhasil. Hapus token di client.']);
    }
}
