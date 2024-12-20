<?php

use App\Http\Controllers\Admin\ResepObatController as AdminResepObatController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApotekerController;
use App\Http\Controllers\PemilikHewanController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\DokterDashboardController;
use App\Http\Controllers\HewanController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\KonsumenDashboardController;
use App\Http\Controllers\ResepObatController;
use App\Http\Controllers\LayananController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Auth::routes(['verify' => true]);

//admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard Admin
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    //pemilik hewan
    Route::resource('pemilik_hewan', PemilikHewanController::class);
});

// Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
//     Route::get('/users', [UserController::class, 'index'])->name('user');
//     Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
//     Route::post('/users', [UserController::class, 'store'])->name('user.store');
//     Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
//     Route::put('/users/{user}', [UserController::class, 'update'])->name('user.update');
//     Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('user.destroy');
// });

// //obat
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('obat', ObatController::class);
});

//dokter
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    //pemilik hewan
    Route::resource('dokter', DokterController::class);
});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('layanan', LayananController::class);
});

//hewan
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('hewan', HewanController::class);
});

//konsultasi
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('konsultasi', KonsultasiController::class);
});

//role apoteker
//dashboard apoteker
Route::middleware(['auth', 'role:apoteker'])->prefix('apoteker')->name('apoteker.')->group(function () {
    Route::get('/dashboard', [ApotekerController::class, 'index'])->name('dashboard');
});

//obat
Route::middleware(['auth', 'role:apoteker'])->prefix('apoteker')->name('apoteker.')->group(function () {
    Route::resource('obat', ObatController::class);
});

//resep obat
Route::middleware(['auth', 'role:apoteker'])->prefix('apoteker')->name('apoteker.')->group(function () {
    Route::resource('resep_obat', ResepObatController::class);
});

//role dokter
//dashboard dokter
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/konsultasi', [DokterDashboardController::class, 'konsultasi'])->name('konsultasi.index'); // Menampilkan daftar konsultasi
    Route::get('/konsultasi/{id}/diagnosis', [DokterDashboardController::class, 'diagnosis'])->name('konsultasi.diagnosis'); // Form diagnosis
    Route::post('/konsultasi/{id}/diagnosis', [DokterDashboardController::class, 'storeDiagnosis'])->name('konsultasi.storeDiagnosis'); // Simpan diagnosis
    Route::get('/diagnosis', [DokterDashboardController::class, 'diagnosis'])->name('admin.konsultasi.index');
    Route::get('/dashboard', [DokterDashboardController::class, 'dokter'])->name('dashboard');
});

//role konsumen
//dashboard konsumen
Route::middleware(['auth', 'role:pemilik_hewan'])->prefix('pemilik-hewan')->name('pemilik-hewan.')->group(function () {
    Route::get('/dashboard', [KonsumenDashboardController::class, 'index'])->name('dashboard');
});

//hewan
Route::middleware(['auth', 'role:pemilik_hewan'])->prefix('pemilik-hewan')->name('pemilik-hewan.')->group(function () {
    Route::resource('hewan', HewanController::class);
});

//konsumen
Route::middleware(['auth', 'role:pemilik_hewan'])->prefix('pemilik-hewan')->name('pemilik-hewan.')->group(function () {
    Route::resource('pemilik_hewan', PemilikHewanController::class);
});

//konsultasi
Route::middleware(['auth', 'role:pemilik_hewan'])->prefix('pemilik-hewan')->name('pemilik-hewan.')->group(function () {
    Route::resource('konsultasi', KonsultasiController::class);
});