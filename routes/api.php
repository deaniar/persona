<?php

use App\Http\Controllers\API\ArtikelController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\DokterController;
use App\Http\Controllers\API\PasienController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/pasien', [PasienController::class, 'index']);
    Route::get('/pasien/{id}', [PasienController::class, 'show']);
    Route::get('/pasien/{id}/edit', [PasienController::class, 'edit']);
    Route::get('/pasien/{id}/booking', [PasienController::class, 'booking']);
    Route::post('/pasien/edit', [PasienController::class, 'update']);
    Route::delete('/pasien/delete', [PasienController::class, 'delete']);

    Route::get('/dokter', [DokterController::class, 'index']);
    Route::get('/dokter/{id}', [DokterController::class, 'show']);
    Route::get('/dokter/{id}/edit', [DokterController::class, 'edit']);
    Route::get('/dokter/{id}/booking', [DokterController::class, 'booking']);
    Route::get('/dokter/{id}/review', [DokterController::class, 'review']);
    Route::post('/dokter/edit', [DokterController::class, 'update']);
    Route::delete('/dokter/delete', [DokterController::class, 'delete']);
    Route::post('/dokter/review', [DokterController::class, 'review']);

    Route::get('/booking', [BookingController::class, 'index']);
    Route::post('/booking', [BookingController::class, 'create']);
    Route::get('/booking/{id}', [BookingController::class, 'show']);
    Route::get('/booking/{id}/edit', [BookingController::class, 'edit']);
    Route::put('/booking/edit', [BookingController::class, 'update']);
    Route::delete('/booking/delete', [BookingController::class, 'delete']);

    Route::get('/artikel', [ArtikelController::class, 'index']);
    Route::get('/artikel/{id}', [ArtikelController::class, 'show']);
    Route::get('/artikel/{id}/edit', [ArtikelController::class, 'edit']);
    Route::post('/artikel/edit', [ArtikelController::class, 'update']);
    Route::post('/artikel', [ArtikelController::class, 'create']);
    Route::delete('/artikel/delete', [ArtikelController::class, 'delete']);


    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
