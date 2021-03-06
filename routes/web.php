<?php

use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\KategoriController;

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
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');



Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
Route::get('/reset-password/t={token}&e={email}', [AuthController::class, 'resetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');


Route::group(['middleware' => ['auth']], function () {

    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile/edit');
    Route::post('/user/update', [UserController::class, 'updateProfile'])->name('/user/update');
    Route::post('/user/update-account', [UserController::class, 'updateAccount'])->name('/user/update-account');

    Route::post('/address/city', [AddressController::class, 'city'])->name('address.city');
    Route::post('/address/district', [AddressController::class, 'district'])->name('address.district');

    Route::get('/doctors/{id}/jadwal', [JadwalController::class, 'index'])->name('jadwal');
    Route::post('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
    Route::get('/doctors/{id_dokter}/jadwal/{id_jadwal}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::post('/jadwal/update', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::post('/jadwal/delete', [JadwalController::class, 'delete'])->name('jadwal.delete');

    Route::group(['middleware' => 'check_account:admin'], function () {
        Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin');
        Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
        Route::get('/admin/users/add', [AdminController::class, 'add'])->name('admin.add');
        Route::post('/admin/users/create', [AdminController::class, 'create'])->name('admin.create');
        Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
        Route::post('/admin/users/update', [AdminController::class, 'update'])->name('admin.update');
        Route::post('/admin/users/update-account', [AdminController::class, 'updateAccount'])->name('admin.update_account');
        Route::post('/admin/users/delete', [AdminController::class, 'delete'])->name('admin.delete');

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

        Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
        Route::post('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
        Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::post('/kategori/update', [KategoriController::class, 'update'])->name('kategori.update');
        Route::post('/kategori/delete', [KategoriController::class, 'delete'])->name('kategori.delete');

        Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel');
        Route::get('/artikel/add', [ArtikelController::class, 'add'])->name('artikel.add');
        Route::post('/artikel/create', [ArtikelController::class, 'create'])->name('artikel.create');
        Route::get('/artikel/show/{id}', [ArtikelController::class, 'show'])->name('artikel.show');
        Route::get('/artikel/show/{id}/edit', [ArtikelController::class, 'edit'])->name('artikel.edit');
        Route::post('/artikel/update', [ArtikelController::class, 'update'])->name('artikel.update');
        Route::post('/artikel/delete', [ArtikelController::class, 'delete'])->name('artikel.delete');

        Route::get('/admin/appointments', [BookingController::class, 'index'])->name('appointments');
    });

    Route::group(['middleware' => 'check_account:dokter'], function () {
        Route::get('/dokter', function () {
            return redirect()->route('profile');
        });
        // Route::get('/dokter', [UserController::class, 'index'])->name('dokter');
        Route::get('/appointments', [BookingController::class, 'show'])->name('booking');
        Route::post('/appointments/update', [BookingController::class, 'update'])->name('booking.update');
        Route::get('/riwayat', [BookingController::class, 'riwayat'])->name('riwayat');
    });
});

Route::get('{any}', function () {
    return redirect()->route('login');
});
