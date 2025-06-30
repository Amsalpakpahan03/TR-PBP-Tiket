<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// === Tiket Service ===
Route::middleware('jwt')->group(function () {
    Route::get('/tiket', fn() => Http::withToken(session('jwt_token'))->get('http://localhost:8003/api/tiket')->json());
    Route::get('/tiket/user/{id}', fn($id) => Http::withToken(session('jwt_token'))->get("http://localhost:8003/api/tiket/user/$id")->json());
    Route::post('/tiket', fn() => Http::withToken(session('jwt_token'))->post("http://localhost:8003/api/tiket", request()->all())->json());
    Route::delete('/tiket/{id}', fn($id) => Http::withToken(session('jwt_token'))->delete("http://localhost:8003/api/tiket/$id")->json());
});
