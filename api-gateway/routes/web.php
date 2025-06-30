<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

// 🔐 GET: Tampilkan form login
Route::get('/login', function () {
    return view('login');
});

// 🔐 POST: Proses login ke auth-service
Route::post('/api/auth/login', function (Request $request) {
    $response = Http::post('http://localhost:8001/api/auth/login', [ // port auth-service
        'email' => $request->email,
        'password' => $request->password,
    ]);

    if ($response->failed()) {
        return back()->with('error', 'Login gagal! Email atau password salah.');
    }

    $token = $response->json()['token'] ?? null;

    if ($token) {
        session(['jwt_token' => $token]);
        return redirect('/'); // bisa juga redirect ke '/tiket'
    }

    return back()->with('error', 'Token tidak ditemukan.');
});

// 📝 GET: Tampilkan form register
Route::get('/register', function () {
    return view('register');
});

// 📝 POST: Proses register ke auth-service
Route::post('/api/auth/register', function (Request $request) {
    $response = Http::post('http://localhost:8001/api/auth/register', [
        'name' => $request->name,
        'email' => $request->email,
        'password' => $request->password,
    ]);

    if ($response->successful()) {
        return redirect('/login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    return back()->with('error', 'Registrasi gagal.');
});

// 🧭 GET: Halaman utama (dashboard atau redirect ke /tiket)
Route::get('/', function () {
    if (!session('jwt_token')) {
        return redirect('/login');
    }

    return redirect('/tiket');
});

// 🧾 GET: Daftar tiket berdasarkan user ID (ambil dari JWT)
Route::get('/tiket', function () {
    $token = session('jwt_token');
    if (!$token) return redirect('/login');

    $user_id = getUserIdFromJWT($token); // helper di helpers.php
    $tiket = Http::withToken($token)->get("http://localhost:8003/api/tiket/user/$user_id")->json();

    return view('tiket.index', compact('tiket'));
});

// 🧾 GET: Form pemesanan tiket
Route::get('/pesan', function () {
    if (!session('jwt_token')) return redirect('/login');
    return view('tiket.pesan');
});

// 🧾 POST: Kirim tiket baru
Route::post('/pesan', function () {
    $token = session('jwt_token');
    $user_id = getUserIdFromJWT($token);

    $body = array_merge(request()->all(), ['user_id' => $user_id]);

    Http::withToken($token)->post('http://localhost:8003/api/tiket', $body);
    return redirect('/tiket');
});

// 🚪 GET: Logout user
Route::get('/logout', function () {
    session()->forget('jwt_token');
    return redirect('/login')->with('success', 'Berhasil logout.');
});
