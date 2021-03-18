<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile/edit');
    Route::post('/user/update', [UserController::class, 'updateProfile'])->name('/user/update');
    Route::post('/user/update-account', [UserController::class, 'updateAccount'])->name('/user/update-account');

    Route::group(['middleware' => 'check_account:admin'], function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    });

    Route::group(['middleware' => 'check_account:dokter'], function () {
        Route::get('/dokter', [UserController::class, 'index'])->name('dokter');
    });
});
