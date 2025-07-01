<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeretaController;

/*
|--------------------------------------------------------------------------
| API Routes - Kereta Service
|--------------------------------------------------------------------------
| Route publik: bisa diakses tanpa token (untuk lihat daftar kereta)
| Route private: hanya bisa diakses jika sudah login (token valid)
|--------------------------------------------------------------------------
*/

// === ROUTE PUBLIK === //
Route::get('/kereta', [KeretaController::class, 'index']);
Route::get('/kereta/{id}/kursi-kosong', [KeretaController::class, 'kursiKosong']);
Route::get('/kursi-detail/cek', [KeretaController::class, 'cekKursi']);

// === ROUTE PRIVATE (butuh JWT) === //
Route::middleware('jwt')->group(function () {
    Route::post('/kereta', [KeretaController::class, 'store']);
    Route::put('/kereta/{id}', [KeretaController::class, 'update']);
    Route::delete('/kereta/{id}', [KeretaController::class, 'destroy']);
    Route::put('/kursi-detail/{kereta_id}/{kode}/pakai', [KeretaController::class, 'tandaiTerpakai']);
});
