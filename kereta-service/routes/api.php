<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeretaController;

/*
|--------------------------------------------------------------------------
| API Routes - Kereta Service
|--------------------------------------------------------------------------
| Semua route terbuka untuk testing/integrasi.
| Tidak ada middleware jwt.
|--------------------------------------------------------------------------
*/

// === ROUTE TERKAIT KERETA === //
Route::get('/kereta', [KeretaController::class, 'index']);
Route::post('/kereta', [KeretaController::class, 'store']);
Route::put('/kereta/{id}', [KeretaController::class, 'update']);
Route::delete('/kereta/{id}', [KeretaController::class, 'destroy']);

// === ROUTE TERKAIT KURSI === //
Route::get('/kereta/{id}/kursi-kosong', [KeretaController::class, 'kursiKosong']);
Route::get('/kursi-detail/cek', [KeretaController::class, 'cekKursi']);
Route::put('/kursi-detail/{kereta_id}/{kode}/pakai', [KeretaController::class, 'tandaiTerpakai']);
