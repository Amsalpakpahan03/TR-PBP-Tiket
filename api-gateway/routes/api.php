<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

// === AUTH ===
Route::prefix('auth')->group(function () {
    Route::post('/login', fn() => Http::post('http://localhost:8001/api/auth/login', request()->all())->json());
    Route::post('/register', fn() => Http::post('http://localhost:8001/api/auth/register', request()->all())->json());
});
Route::middleware('jwt')->prefix('tiket')->group(function () {
    Route::post('/', fn() => Http::withToken(request()->bearerToken())
        ->post('http://localhost:8003/api/tiket', request()->all())->json());
});


// === KERETA ===
Route::prefix('kereta')->middleware('jwt')->group(function () {
    Route::get('/', fn() => Http::withToken(request()->bearerToken())->get('http://localhost:8002/api/kereta')->json());
    Route::post('/', fn() => Http::withToken(request()->bearerToken())->post('http://localhost:8002/api/kereta', request()->all())->json());
    Route::put('/{id}', fn($id) => Http::withToken(request()->bearerToken())->put("http://localhost:8002/api/kereta/$id", request()->all())->json());
    Route::delete('/{id}', fn($id) => Http::withToken(request()->bearerToken())->delete("http://localhost:8002/api/kereta/$id")->json());
});

// === TIKET ===
Route::prefix('tiket')->middleware('jwt')->group(function () {
    Route::get('/', fn() => Http::withToken(request()->bearerToken())->get('http://localhost:8003/api/tiket')->json());
    Route::get('/user/{id}', fn($id) => Http::withToken(request()->bearerToken())->get("http://localhost:8003/api/tiket/user/$id")->json());
    Route::post('/', fn() => Http::withToken(request()->bearerToken())->post('http://localhost:8003/api/tiket', request()->all())->json());
    Route::delete('/{id}', fn($id) => Http::withToken(request()->bearerToken())->delete("http://localhost:8003/api/tiket/$id")->json());
});

// === Kursi (Proxy dari gateway ke kereta-service) ===
Route::get('/kursi-detail/cek', function () {
    $keretaId = request('kereta_id');
    $kode = request('kode');

    $response = Http::get('http://localhost:8002/api/kursi-detail/cek', [
        'kereta_id' => $keretaId,
        'kode' => $kode
    ]);

    return response($response->body(), $response->status());
});
