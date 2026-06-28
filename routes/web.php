<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\InstansiController;
use App\Http\Controllers\Admin\MenuMakananController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;

// Redirect root ke login
Route::get('/', function () {
    return redirect('/login');
});

// Rute Autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Foto Profil (Semua user yang sudah login)
Route::middleware(['auth'])->group(function () {
    Route::post('/profile/foto', [ProfileController::class, 'updateFoto'])->name('profile.foto.update');
    Route::delete('/profile/foto', [ProfileController::class, 'hapusFoto'])->name('profile.foto.delete');
});

// Rute Grup Admin (Dilindungi Auth & Role Admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::resource('instansi', InstansiController::class);
    Route::resource('menu', MenuMakananController::class);
    Route::resource('pengajuan', \App\Http\Controllers\Admin\PengajuanController::class)->only(['index', 'show', 'destroy']);
    Route::post('pengajuan/{pengajuan}/verifikasi', [\App\Http\Controllers\Admin\PengajuanController::class, 'verifikasi'])->name('pengajuan.verifikasi');
    Route::resource('penyaluran', \App\Http\Controllers\Admin\PenyaluranController::class);

    // Laporan
    Route::get('laporan/pengajuan', [\App\Http\Controllers\Admin\LaporanController::class, 'pengajuan'])->name('laporan.pengajuan');
    Route::get('laporan/pengajuan/pdf', [\App\Http\Controllers\Admin\LaporanController::class, 'pengajuanPdf'])->name('laporan.pengajuan.pdf');
    Route::get('laporan/penyaluran', [\App\Http\Controllers\Admin\LaporanController::class, 'penyaluran'])->name('laporan.penyaluran');
    Route::get('laporan/penyaluran/pdf', [\App\Http\Controllers\Admin\LaporanController::class, 'penyaluranPdf'])->name('laporan.penyaluran.pdf');

    // Manajemen User
    Route::resource('users', UserController::class)->except(['show']);
    Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
});

// Rute Grup Instansi (Dilindungi Auth & Role Instansi)
Route::middleware(['auth', 'role:instansi'])->prefix('instansi')->name('instansi.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'instansi'])->name('dashboard');
    Route::resource('pengajuan', \App\Http\Controllers\Instansi\PengajuanController::class);
    Route::get('/profil', [\App\Http\Controllers\Instansi\ProfilController::class, 'show'])->name('profil');
    Route::put('/profil', [\App\Http\Controllers\Instansi\ProfilController::class, 'update'])->name('profil.update');
});
