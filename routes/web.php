<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
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

    Route::get('/doctors/{id}/jadwal', [JadwalController::class, 'index'])->name('jadwal');
    Route::post('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
    Route::get('/doctors/{id_dokter}/jadwal/{id_jadwal}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::post('/jadwal/update', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::post('/jadwal/delete', [JadwalController::class, 'delete'])->name('jadwal.delete');

    Route::group(['middleware' => 'check_account:admin'], function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
        Route::get('/doctors', [DokterController::class, 'index'])->name('doctors');
        Route::get('/doctors/add', [DokterController::class, 'add'])->name('doctors.add');
        Route::post('/doctors/create', [DokterController::class, 'create'])->name('doctors.create');
        Route::get('/doctors/{id}', [DokterController::class, 'show'])->name('doctors.id');
        Route::get('/doctors/{id}/edit', [DokterController::class, 'edit'])->name('doctors.edit');
        Route::post('/doctors/update', [DokterController::class, 'update'])->name('doctors.update');
        Route::post('/doctors/update-account', [DokterController::class, 'updateAccount'])->name('doctors.update_account');
        Route::post('/doctors/delete', [DokterController::class, 'delete'])->name('doctors.delete');

        Route::get('/patients', [PasienController::class, 'index'])->name('patients');
        Route::get('/patients/add', [PasienController::class, 'add'])->name('patients.add');
        Route::post('/patients/create', [PasienController::class, 'create'])->name('patients.create');
        Route::get('/patients/{id}/edit', [PasienController::class, 'edit'])->name('patients.edit');
        Route::post('/patients/update', [PasienController::class, 'update'])->name('patients.update');
        Route::post('/patients/update-account', [PasienController::class, 'updateAccount'])->name('patients.update_account');
        Route::post('/patients/delete', [PasienController::class, 'delete'])->name('patients.delete');
    });

    Route::group(['middleware' => 'check_account:dokter'], function () {
        Route::get('/dokter', [UserController::class, 'index'])->name('dokter');
        Route::get('/appointments', [BookingController::class, 'index'])->name('booking');
        Route::post('/appointments/update', [BookingController::class, 'update'])->name('booking.update');
        Route::get('/riwayat', [BookingController::class, 'riwayat'])->name('riwayat');
    });
});
