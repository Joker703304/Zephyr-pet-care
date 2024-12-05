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
//  Route::get('/pemilik_hewan', [PemilikHewanController::class, 'index'])->name('pemilik_hewan');
//  Route::get('/pemilik_hewan/create', [PemilikHewanController::class, 'create'])->name('pemilik_hewan.create');
//  Route::post('/pemilik_hewan', [PemilikHewanController::class, 'store'])->name('pemilik_hewan.store');
//  Route::get('/pemilik_hewan/{pemilik_hewan}/edit', [PemilikHewanController::class, 'edit'])->name('pemilik_hewan.edit');
//  Route::put('/pemilik_hewan/{pemilik_hewan}', [PemilikHewanController::class, 'update'])->name('pemilik_hewan.update');
//  Route::delete('/pemilik_hewan/{pemilik_hewan}', [PemilikHewanController::class, 'destroy'])->name('pemilik_hewan.destroy');
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
    // Route::get('/obat/create', [ObatController::class, 'create'])->name('obat.create');
    // Route::post('/obat', [ObatController::class, 'store'])->name('obat.store');
    // Route::get('/obat/{obat}/edit', [ObatController::class, 'edit'])->name('obat.edit');
    // Route::put('/obat/{obat}', [ObatController::class, 'update'])->name('obat.update');
    // Route::delete('/obat/{obat}', [ObatController::class, 'destroy'])->name('obat.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    //pemilik hewan
    Route::resource('dokter', DokterController::class);
   });

//apoteker
Route::middleware(['auth', 'role:apoteker'])->prefix('apoteker')->name('apoteker.')->group(function () {
    Route::get('/dashboard', [ApotekerController::class, 'index'])->name('dashboard');
});