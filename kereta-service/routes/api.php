<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeretaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::get('/kereta', [KeretaController::class, 'index']);
Route::post('/kereta', [KeretaController::class, 'store']);
Route::put('/kereta/{id}', [KeretaController::class, 'update']);
Route::delete('/kereta/{id}', [KeretaController::class, 'destroy']);
Route::put('/kereta/{id}/kurangi-stok', [KeretaController::class, 'kurangiStok']);
