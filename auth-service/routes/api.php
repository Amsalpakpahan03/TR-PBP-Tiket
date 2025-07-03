<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


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

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Menambahkan rute untuk logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

// Rute untuk mendapatkan profil pengguna (me)
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:api'); // Endpoint untuk profil pengguna

