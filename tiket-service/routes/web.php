<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendTiketController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/tiket/pesan', [FrontendTiketController::class, 'create'])->name('tiket.pesan');
Route::post('/tiket/store', [FrontendTiketController::class, 'store'])->name('tiket.store');

