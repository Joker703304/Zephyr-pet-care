<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApotekerController;
use App\Http\Controllers\PemilikHewanController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\HewanController;
use App\Http\Controllers\KonsultasiController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

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

//hewan
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('hewan', HewanController::class);
});

//konsultasi
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('konsultasi', KonsultasiController::class);
});

//apoteker
Route::middleware(['auth', 'role:apoteker'])->prefix('apoteker')->name('apoteker.')->group(function () {
    Route::get('/dashboard', [ApotekerController::class, 'index'])->name('dashboard');
});