<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TiketController;

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


Route::get('/tiket', [TiketController::class, 'index']);
Route::get('/tiket/user/{id}', [TiketController::class, 'userTiket']);
Route::post('/tiket', [TiketController::class, 'store']);
Route::delete('/tiket/{id}', [TiketController::class, 'destroy']);

