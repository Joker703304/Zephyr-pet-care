<?php

use App\Http\Controllers\Admin\ResepObatController as AdminResepObatController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApotekerController;
use App\Http\Controllers\ApotekerAdminController;
use App\Http\Controllers\PemilikHewanController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\KasirAdminController;
use App\Http\Controllers\DokterDashboardController;
use App\Http\Controllers\HewanController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\KonsultasiPemilikController;
use App\Http\Controllers\KonsumenDashboardController;
use App\Http\Controllers\ResepObatController;
use App\Http\Controllers\LayananController;
use App\Models\Apoteker;
use App\Models\Kasir;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\ResepObat;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Auth::routes(['verify' => true]);


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/pemilik-hewan/dashboard', [PemilikHewanController::class, 'index'])
        ->name('pemilik-hewan.dashboard');
});


//admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard Admin
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    //pemilik hewan
    Route::resource('pemilik_hewan', PemilikHewanController::class);
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
});

// //obat
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('obat', ObatController::class);
});

//dokter
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    //pemilik hewan
    Route::post('kasir/register', [KasirAdminController::class, 'registerStore'])->name('kasir.register');
    Route::post('dokter/register', [DokterController::class, 'registerStore'])->name('dokter.register');
    Route::post('apoteker/register', [ApotekerAdminController::class, 'registerStore'])->name('apoteker.register');
    Route::resource('dokter', DokterController::class);
    Route::resource('kasir', KasirAdminController::class);
    Route::resource('apoteker', ApotekerAdminController::class);
});
Route::post('/admin/dokter/find-user', [DokterController::class, 'findUserByEmail'])->name('admin.dokter.findUser');


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
    Route::get('/create-profile', [ApotekerController::class, 'createProfile'])->name('createProfile');
    Route::post('/store-profile', [ApotekerController::class, 'storeProfile'])->name('storeProfile');
    Route::get('/edit-profile', [ApotekerController::class, 'editProfile'])->name('editProfile');
    Route::post('/update-profile', [ApotekerController::class, 'updateProfile'])->name('updateProfile');
    Route::get('/dashboard', [ApotekerController::class, 'index'])->name('dashboard');
});

//obat
Route::middleware(['auth', 'role:apoteker'])->prefix('apoteker')->name('apoteker.')->group(function () {
    Route::resource('obat', ObatController::class);
});

//resep obat
Route::middleware(['auth', 'role:apoteker'])->prefix('apoteker')->name('apoteker.')->group(function () {
    Route::resource('resep_obat', ResepObatController::class);
    Route::get('/resep-obat/{id_konsultasi}/edit', [ResepObatController::class, 'edit'])->name('apoteker.resep_obat.edit');
});

Route::get('/reses-obat/history', [ResepObatController::class, 'history'])->name('apoteker.resep_obat.history');
//role dokter
//dashboard dokter
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dokter/create-profile', [DokterDashboardController::class, 'createProfile'])->name('createProfile');
    Route::post('/dokter/store-profile', [DokterDashboardController::class, 'storeProfile'])->name('storeProfile');
    Route::get('/dokter/edit-profile', [DokterDashboardController::class, 'editProfile'])->name('editProfile');
    Route::post('/dokter/update-profile', [DokterDashboardController::class, 'updateProfile'])->name('updateProfile');
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

 Route::middleware(['auth', 'role:pemilik_hewan'])->prefix('pemilik-hewan')->name('pemilik-hewan.')->group(function () {
     Route::resource('resep_obat', ResepObat::class);
 });

//konsumen
Route::middleware(['auth', 'role:pemilik_hewan'])->prefix('pemilik-hewan')->name('pemilik-hewan.')->group(function () {
    Route::resource('pemilik_hewan', PemilikHewanController::class);
    Route::resource('konsultasi_pemilik', KonsultasiPemilikController::class);
});

//konsultasi
Route::middleware(['auth', 'role:pemilik_hewan'])->prefix('pemilik-hewan')->name('pemilik-hewan.')->group(function () {
    Route::resource('konsultasi', KonsultasiController::class);
});
