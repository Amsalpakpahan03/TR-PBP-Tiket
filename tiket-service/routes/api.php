<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TiketController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (tanpa login)
|--------------------------------------------------------------------------
*/
Route::get('/tiket', [TiketController::class, 'index']);
Route::get('/tiket/user/{id}', [TiketController::class, 'userTiket']);

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (butuh JWT login)
|--------------------------------------------------------------------------
*/
Route::middleware('jwt')->group(function () {
    Route::get('/tiket/riwayat', [TiketController::class, 'riwayatUser']);
    Route::post('/tiket', [TiketController::class, 'store']);
    Route::put('/tiket/{id}/bayar', [TiketController::class, 'bayar']);
    Route::delete('/tiket/{id}', [TiketController::class, 'destroy']);
});
