<?php

use App\Http\Controllers\Admin\ResepObatController as AdminResepObatController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApotekerController;
use App\Http\Controllers\ApotekerAdminController;
use App\Http\Controllers\PemilikHewanController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\KasirAdminController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\DokterDashboardController;
use App\Http\Controllers\HewanController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\KonsultasiPemilikController;
use App\Http\Controllers\KonsumenDashboardController;
use App\Http\Controllers\ResepObatController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\DokterJadwalController;
use App\Http\Controllers\SecurityAdminController;
use App\Http\Controllers\SecurityController;
use App\Models\Apoteker;
use App\Models\DokterJadwal;
use App\Models\Kasir;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\ResepObat;
use App\Models\Security;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Auth::routes(['verify' => true]);


Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
->middleware(['signed']) // Hanya signed, tanpa 'auth'
->name('verification.verify');

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
    Route::post('security/register', [SecurityAdminController::class, 'registerStore'])->name('security.register');
    Route::resource('dokter', DokterController::class);
    Route::get('/dokter/{id}/jadwal', [DokterController::class, 'jadwal'])->name('dokter.jadwal');
    Route::post('/jadwal/storeOrUpdate', [DokterController::class, 'storeOrUpdate'])->name('jadwal.storeOrUpdate');
    Route::resource('kasir', KasirAdminController::class);
    Route::resource('security', SecurityAdminController::class);
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
});

//role apoteker
//dashboard apoteker
Route::middleware(['auth', 'role:apoteker'])->prefix('apoteker')->name('apoteker.')->group(function () {
    Route::get('/profile', [ApotekerController::class, 'profile'])->name('profile');
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
    Route::get('/jadwal', [DokterJadwalController::class, 'index'])->name('jadwal.dokter');
    Route::post('/jadwal', [DokterJadwalController::class, 'store'])->name('jadwal.store');
    Route::put('/jadwal/{id}', [DokterJadwalController::class, 'update'])->name('jadwal.update');
    Route::post('/jadwal/storeOrUpdate', [DokterJadwalController::class, 'storeOrUpdate'])->name('jadwal.storeOrUpdate');
    Route::patch('/antrian/{antrian}/panggil', [DokterDashboardController::class, 'panggil'])->name('antrian.panggil');
    Route::get('/profile', [DokterDashboardController::class, 'index'])->name('profile');
    Route::get('/dokter/create-profile', [DokterDashboardController::class, 'createProfile'])->name('createProfile');
    Route::post('/dokter/store-profile', [DokterDashboardController::class, 'storeProfile'])->name('storeProfile');
    Route::get('/dokter/edit-profile', [DokterDashboardController::class, 'editProfile'])->name('editProfile');
    Route::post('/dokter/update-profile', [DokterDashboardController::class, 'updateProfile'])->name('updateProfile');
    Route::get('/konsultasi', [DokterDashboardController::class, 'konsultasi'])->name('konsultasi.index'); // Menampilkan daftar konsultasi
    Route::get('/konsultasi/{id}/diagnosis', [DokterDashboardController::class, 'diagnosis'])->name('konsultasi.diagnosis'); // Form diagnosis
    Route::post('/konsultasi/{id}/diagnosis', [DokterDashboardController::class, 'storeDiagnosis'])->name('konsultasi.storeDiagnosis'); // Simpan diagnosis
    Route::get('/diagnosis', [DokterDashboardController::class, 'diagnosis'])->name('admin.konsultasi.index');
    Route::get('/dashboard', [DokterDashboardController::class, 'dokter'])->name('dashboard');
// API endpoint for storing schedule
Route::post('/api/dokter/jadwal', [DokterJadwalController::class, 'store'])->middleware('auth');

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

Route::middleware(['auth', 'role:pemilik_hewan'])->prefix('pemilik-hewan')->group(function () {
    Route::get('/resep-obat', [ResepObatController::class, 'index'])->name('pemilik-hewan.resep_obat.index');
    Route::get('/resep-obat/{id_konsultasi}/rincian', [ResepObatController::class, 'show'])->name('pemilik-hewan.resep_obat.show');
});

//konsumen
Route::middleware(['auth', 'role:pemilik_hewan'])->prefix('pemilik-hewan')->name('pemilik-hewan.')->group(function () {
    Route::resource('pemilik_hewan', PemilikHewanController::class);
    Route::resource('konsultasi_pemilik', KonsultasiPemilikController::class);
    Route::put('/pemilik-hewan/konsultasi/{id}/cancel', [KonsultasiPemilikController::class, 'cancel'])->name('konsultasi_pemilik.cancel');
    Route::get('/konsultasi/get-dokter-by-date', [KonsultasiPemilikController::class, 'getDokterByDate'])->name('konsultasi_pemilik.getDokterByDate');
    Route::get('/transaksi', [KonsumenDashboardController::class, 'listTransaksi'])->name('transaksi.list');
    Route::get('/transaksi/{id}/rincian', [KonsumenDashboardController::class, 'rincian'])->name('transaksi.rincian');
});

//konsultasi
Route::middleware(['auth', 'role:pemilik_hewan'])->prefix('pemilik-hewan')->name('pemilik-hewan.')->group(function () {
    Route::resource('konsultasi', KonsultasiController::class);
});

Route::middleware(['auth', 'role:kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/profile', [KasirController::class, 'profile'])->name('profile');
    Route::resource('konsultasi', KonsultasiController::class);
    Route::patch('/antrian/{antrian}/selesai', [KasirController::class, 'selesai'])->name('antrian.selesai');
    Route::get('/antrian', [KasirController::class, 'antrian'])->name('antrian.index');
    Route::get('/kasir/antrian/live', [KasirController::class, 'getAntrian'])->name('getAntrian');
    Route::get('/create-profile', [KasirController::class, 'createProfile'])->name('createProfile');
    Route::post('/store-profile', [KasirController::class, 'storeProfile'])->name('storeProfile');
    Route::get('/edit-profile', [KasirController::class, 'editProfile'])->name('editProfile');
    Route::post('/update-profile', [KasirController::class, 'updateProfile'])->name('updateProfile');
    Route::get('/dashboard', [KasirController::class, 'index'])->name('dashboard');
    Route::get('/transaksi', [KasirController::class, 'listTransaksi'])->name('transaksi.list');
    Route::post('kasir/transaksi/{id}/bayar', [KasirController::class, 'bayar'])->name('transaksi.bayar');
Route::get('kasir/transaksi/{id}/rincian', [KasirController::class, 'rincian'])->name('transaksi.rincian');
});


Route::middleware(['auth', 'role:security'])->prefix('security')->name('security.')->group(function () {
    Route::get('/profile', [SecurityController::class, 'profile'])->name('profile');
    Route::get('/antrian/live', [SecurityController::class, 'getAntrian'])->name('getAntrian');
    Route::get('/create-profile', [SecurityController::class, 'createProfile'])->name('createProfile');
    Route::post('/store-profile', [SecurityController::class, 'storeProfile'])->name('storeProfile');
    Route::get('/edit-profile', [SecurityController::class, 'editProfile'])->name('editProfile');
    Route::post('/update-profile', [SecurityController::class, 'updateProfile'])->name('updateProfile');
    Route::get('/dashboard', [SecurityController::class, 'index'])->name('dashboard');
});


