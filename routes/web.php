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
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
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
use App\Http\Controllers\CodeOtpController;
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


Route::post('/password/send-otp', [ForgotPasswordController::class, 'sendResetOtp'])
    ->middleware('throttle:5,1') // Batasi pengiriman OTP agar tidak disalahgunakan
    ->name('password.sendOtp');

Route::get('/password/resetform', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset.form');

Route::post('/password/update', [ResetPasswordController::class, 'reset'])
    ->middleware('throttle:5,1') // Batasi reset password agar tidak disalahgunakan
    ->name('password.update');
Route::post('/send-otp', [CodeOtpController::class, 'sendOtp'])->middleware('throttle:send-otp')->name('send-otp');
// Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
// ->middleware(['signed']) // Hanya signed, tanpa 'auth'
// ->name('verification.verify');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


// Reset Password Bawaan Laravel
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::middleware('auth')->group(function () {
    Route::patch('/pemilik-hewan/{id}/update-password', [PemilikHewanController::class, 'updatePassword'])->name('pemilik-hewan.update-password');
});

Route::middleware('auth')->group(function () {
    Route::patch('/dokter/{id}/update-password', [DokterDashboardController::class, 'updatePassword'])->name('dokter.update-password');
});

Route::middleware('auth')->group(function () {
    Route::patch('/apoteker/{id}/update-password', [ApotekerController::class, 'updatePassword'])->name('apoteker.update-password');
});

Route::middleware('auth')->group(function () {
    Route::patch('/kasir/{id}/update-password', [KasirController::class, 'updatePassword'])->name('kasir.update-password');
});

Route::middleware('auth')->group(function () {
    Route::patch('/security/{id}/update-password', [SecurityController::class, 'updatePassword'])->name('security.update-password');
});

Route::middleware(['auth'])->group(function () {
        Route::get('/pemilik-hewan/dashboard', [PemilikHewanController::class, 'index'])
        ->name('pemilik-hewan.dashboard');
        Route::post('/send-otp-change-number', [CodeOtpController::class, 'sendOtpChangeNumber'])->name('sendOtpChangeNumber');
        Route::post('/verify-otp-change-number', [CodeOtpController::class, 'verifyOtpChangeNumber'])->name('verifyOtpChangeNumber');
        Route::put('/admin/users/{user}/update-role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');
        Route::post('/send-otp-change-password', [CodeOtpController::class, 'sendOtpChangePassword'])->name('sendOtpChangePassword');
Route::post('/verify-otp-change-password', [CodeOtpController::class, 'verifyOtpChangePassword'])->name('verifyOtpChangePassword');

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
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
    Route::get('/laporan/export', [AdminController::class, 'exportLaporan'])->name('export-laporan');
    Route::get('/admin/export-laporan-pdf', [AdminController::class, 'exportLaporanPdf'])->name('admin.export-laporan.pdf');

    Route::get('/laporan/export-pdf', [AdminController::class, 'exportLaporanPdf'])->name('laporan.pdf');
    

});
Route::post('/admin/dokter/find-user', [DokterController::class, 'findUserByEmail'])->name('admin.dokter.findUser');


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('layanan', LayananController::class);
});

//hewan
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Definisikan route resource untuk hewan
    Route::resource('hewan', HewanController::class)->except(['show']);

    // Route untuk menampilkan daftar jenis hewan
    Route::get('hewan/show-jenis', [HewanController::class, 'showJenis'])->name('hewan.show-jenis');

    // Route untuk menambah jenis hewan
    Route::get('hewan/create-jenis', [HewanController::class, 'createJenis'])->name('hewan.create-jenis');
    Route::post('hewan/store-jenis', [HewanController::class, 'storeJenis'])->name('hewan.store-jenis');

    // ✅ Tambahkan yang ini:
    Route::get('hewan/{id}/edit-jenis', [HewanController::class, 'editJenis'])->name('hewan.edit-jenis');
    Route::put('hewan/{id}/update-jenis', [HewanController::class, 'updateJenis'])->name('hewan.update-jenis');
    Route::delete('hewan/{id}/delete-jenis', [HewanController::class, 'deleteJenis'])->name('hewan.delete-jenis');
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
    Route::match(['post', 'put'],'/update-profile', [ApotekerController::class, 'updateProfile'])->name('updateProfile');
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
    Route::delete('/hewan/{id}', [HewanController::class, 'destroy'])->name('pemilik-hewan.hewan.destroy');
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
    Route::get('/transaksi/riwayat', [KasirController::class, 'riwayatTransaksi'])->name('transaksi.riwayat');
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


