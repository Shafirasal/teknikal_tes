<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JenisKendaraanController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PenerimaanPeminjamanController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// Halaman Welcome (tanpa login)
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Rute Auth (Opsional, jika tidak digunakan bisa dihapus)
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin'])->name('login.post');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');



Route::group(['middleware' => 'auth'], function () {
// Level Management (tanpa login)
Route::group(['prefix' => 'level', 'middleware' => 'authorize:ADM'], function () {
    Route::get('/', [LevelController::class, 'index'])->name('level.index');
    Route::post('/list', [LevelController::class, 'list'])->name('level.list');
    Route::get('/create', [LevelController::class, 'create'])->name('level.create');
    Route::post('/store', [LevelController::class, 'store'])->name('level.store');
    Route::get('/{id}/show', [LevelController::class, 'show'])->name('level.show');
    Route::get('/{id}/edit', [LevelController::class, 'edit'])->name('level.edit');
    Route::put('/{id}/update', [LevelController::class, 'update'])->name('level.update');
    Route::get('/{id}/confirm', [LevelController::class, 'confirm'])->name('level.confirm');
    Route::delete('/{id}/delete', [LevelController::class, 'delete'])->name('level.delete');
});

// User Management (tanpa login)
Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::post('/list', [UserController::class, 'list'])->name('user.list');
    Route::get('/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/{id}/show', [UserController::class, 'show'])->name('user.show');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/{id}/update', [UserController::class, 'update'])->name('user.update');
    Route::get('/{id}/confirm', [UserController::class, 'confirm'])->name('user.confirm');
    Route::delete('/{id}/delete', [UserController::class, 'delete'])->name('user.delete');
    Route::get('/import', [UserController::class, 'import'])->name('user.import');
});


// Route::group(['prefix' => 'peminjaman'], function () {
//     Route::get('/', [PeminjamanController::class, 'index'])->name('peminjaman.index');
//     Route::post('/list', [PeminjamanController::class, 'list'])->name('peminjaman.list');
//     Route::get('/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
//     Route::post('/store', [PeminjamanController::class, 'store'])->name('peminjaman.store');
//     Route::get('/{id}/show', [PeminjamanController::class, 'show'])->name('peminjaman.show');
//     Route::get('/{id}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
//     Route::put('/{id}/update', [PeminjamanController::class, 'update'])->name('peminjaman.update');
//     Route::get('/{id}/confirm', [PeminjamanController::class, 'confirm'])->name('peminjaman.confirm');
//     Route::delete('/{id}/delete', [PeminjamanController::class, 'delete'])->name('peminjaman.delete');
//     Route::get('/import', [PeminjamanController::class, 'import'])->name('peminjaman.import');
//     Route::get('/peminjaman/get-users', [PeminjamanController::class, 'getUsersByLevel']);
//     Route::get('/peminjaman/load_data', [PeminjamanController::class, 'load_data']);
//     Route::get('/peminjaman/get-users', [PeminjamanController::class, 'getUsers']);


// });


Route::group(['prefix' => 'peminjaman'], function () {
    Route::get('/', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::post('/list', [PeminjamanController::class, 'list'])->name('peminjaman.list');
    Route::get('/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/store', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/{id}/show', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::get('/{id}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
    Route::put('/{id}/update', [PeminjamanController::class, 'update'])->name('peminjaman.update');
    Route::get('/{id}/confirm', [PeminjamanController::class, 'confirm'])->name('peminjaman.confirm');
    Route::delete('/{id}/delete', [PeminjamanController::class, 'delete'])->name('peminjaman.delete');
    Route::get('/import', [PeminjamanController::class, 'import'])->name('peminjaman.import');
    Route::get('/peminjaman/load_data', [PeminjamanController::class, 'load_data']);
    Route::get('/peminjaman/get-users', [PeminjamanController::class, 'getUsers']);


});

Route::group(['prefix' => 'perusahaan'], function () {
    Route::get('/', [PerusahaanController::class, 'index'])->name('perusahaan.index');
    Route::post('/list', [PerusahaanController::class, 'list'])->name('perusahaan.list');
    Route::get('/create', [PerusahaanController::class, 'create'])->name('perusahaan.create');
    Route::post('/store', [PerusahaanController::class, 'store'])->name('perusahaan.store');
    Route::get('/{id}/show', [PerusahaanController::class, 'show'])->name('perusahaan.show');
    Route::get('/{id}/edit', [PerusahaanController::class, 'edit'])->name('perusahaan.edit');
    Route::put('/{id}/update', [PerusahaanController::class, 'update'])->name('perusahaan.update');
    Route::get('/{id}/confirm', [PerusahaanController::class, 'confirm'])->name('perusahaan.confirm');
    Route::delete('/{id}/delete', [PerusahaanController::class, 'delete'])->name('perusahaan.delete');
    Route::get('/import', [PerusahaanController::class, 'import'])->name('perusahaan.import');
});

Route::group(['prefix' => 'kendaraan'], function () {
    Route::get('/', [KendaraanController::class, 'index'])->name('kendaraan.index');
    Route::post('/list', [KendaraanController::class, 'list'])->name('kendaraan.list');
    Route::get('/create', [KendaraanController::class, 'create'])->name('kendaraan.create');
    Route::post('/store', [KendaraanController::class, 'store'])->name('kendaraan.store');
    Route::get('/{id}/show', [KendaraanController::class, 'show'])->name('kendaraan.show');
    Route::get('/{id}/edit', [KendaraanController::class, 'edit'])->name('kendaraan.edit');
    Route::put('/{id}/update', [KendaraanController::class, 'update'])->name('kendaraan.update');
    Route::get('/{id}/confirm', [KendaraanController::class, 'confirm'])->name('kendaraan.confirm');
    Route::delete('/{id}/delete', [KendaraanController::class, 'delete'])->name('kendaraan.delete');
    Route::get('/import', [KendaraanController::class, 'import'])->name('kendaraan.import');
});


Route::group(['prefix' => 'jeniskendaraan'], function () {
    Route::get('/', [JenisKendaraanController::class, 'index'])->name('jeniskendaraan.index');
    Route::post('/list', [JenisKendaraanController::class, 'list'])->name('jeniskendaraan.list');
    Route::get('/create', [JenisKendaraanController::class, 'create'])->name('jeniskendaraan.create');
    Route::post('/store', [JenisKendaraanController::class, 'store'])->name('jeniskendaraan.store');
    Route::get('/{id}/show', [JenisKendaraanController::class, 'show'])->name('jeniskendaraan.show');
    Route::get('/{id}/edit', [JenisKendaraanController::class, 'edit'])->name('jeniskendaraan.edit');
    Route::put('/{id}/update', [JenisKendaraanController::class, 'update'])->name('jeniskendaraan.update');
    Route::get('/{id}/confirm', [JenisKendaraanController::class, 'confirm'])->name('jeniskendaraan.confirm');
    Route::delete('/{id}/delete', [JenisKendaraanController::class, 'delete'])->name('jeniskendaraan.delete');
    Route::get('/import', [JenisKendaraanController::class, 'import'])->name('jeniskendaraan.import');
});

Route::group(['prefix' => 'penerimaan'], function () {
    Route::get('/', [PenerimaanPeminjamanController::class, 'index'])->name('penerimaan.index');
    Route::post('/list', [PenerimaanPeminjamanController::class, 'list'])->name('penerimaan.list');
    Route::get('/create', [PenerimaanPeminjamanController::class, 'create'])->name('penerimaan.create');
    Route::post('/store', [PenerimaanPeminjamanController::class, 'store'])->name('penerimaan.store');
    Route::get('/{id}/show', [PenerimaanPeminjamanController::class, 'show'])->name('penerimaan.show');
    Route::get('/{id}/edit', [PenerimaanPeminjamanController::class, 'edit'])->name('penerimaan.edit');
    Route::put('/{id}/update', [PenerimaanPeminjamanController::class, 'update'])->name('penerimaan.update');
    Route::get('/{id}/confirm', [PenerimaanPeminjamanController::class, 'confirm'])->name('penerimaan.confirm');
    Route::delete('/{id}/delete', [PenerimaanPeminjamanController::class, 'delete'])->name('penerimaan.delete');
    Route::get('/import', [PenerimaanPeminjamanController::class, 'import'])->name('penerimaan.import');
    Route::post('/{id}/approve', [PenerimaanPeminjamanController::class, 'approve'])->name('penerimaan.approve');
    Route::post('/{id}/reject', [PenerimaanPeminjamanController::class, 'reject'])->name('penerimaan.reject');
});

});