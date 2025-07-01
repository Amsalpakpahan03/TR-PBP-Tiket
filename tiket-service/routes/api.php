<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TiketController;

// Public access (misal: admin frontend atau monitoring)
Route::get('/tiket', [TiketController::class, 'index']);
Route::get('/tiket/user/{id}', [TiketController::class, 'userTiket']);

// // Butuh login (JWT)
// Route::middleware('jwt')->group(function () {
//     Route::post('/tiket', [TiketController::class, 'store']);
//     Route::put('/tiket/{id}/bayar', [TiketController::class, 'bayar']);
//     Route::delete('/tiket/{id}', [TiketController::class, 'destroy']);
// });
Route::middleware('jwt')->get('/tiket/riwayat', [TiketController::class, 'riwayatUser']);

Route::middleware('jwt')->group(function () {
    Route::get('/tiket', [TiketController::class, 'index']);
    Route::get('/tiket/user/{id}', [TiketController::class, 'userTiket']);
    Route::post('/tiket', [TiketController::class, 'store']);
    Route::put('/tiket/{id}/bayar', [TiketController::class, 'bayar']);
    Route::delete('/tiket/{id}', [TiketController::class, 'destroy']);
});
