<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PenelitianController;
use App\Http\Controllers\AbdimasController;
use App\Http\Controllers\PublikasiController;
use App\Http\Controllers\PenerbitanDokumenController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\KiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DataDosenController;
use App\Http\Controllers\DataMahasiswaController;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Custom auth-like routes used by the old views
Route::get('login-page', [App\Http\Controllers\UserController::class, 'menulogin'])->name('menulogin');
Route::post('login', [App\Http\Controllers\UserController::class, 'post_login'])->name('post_login');
Route::get('register-page',  [App\Http\Controllers\UserController::class, 'daftarakun'])->name('daftarakun');
Route::post('register', [App\Http\Controllers\UserController::class, 'post_daftarakun'])->name('post_daftarakun');

//logout
Route::get('logout', [App\Http\Controllers\UserController::class, 'logout'])->name('logout');

// Email Verification Routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [App\Http\Controllers\Auth\VerificationController::class, 'show'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])
        ->middleware('signed')->name('verification.verify');
    Route::post('/email/resend', [App\Http\Controllers\Auth\VerificationController::class, 'resend'])->name('verification.resend');
});

// Password Reset Routes
Route::middleware('guest')->group(function () {
    Route::get('/password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
});


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//dashboard
Route::get('dashboard',[AdminController::class, 'dashboard'])->name('dashboard');

//tentang
Route::get('tentang_profil',[TentangController::class,'profil'])->name('profil');
Route::get('tentang_kerjasama',[TentangController::class, 'kerjasama'])->name('kerjasama');
Route::get('tentang_data_kerjasama',[TentangController::class, 'data_kerjasama'])->name('data_kerjasama');
Route::get('calender', [TentangController::class, 'tanggal'])->name('tanggal');
Route::post('calenderAjax', [TentangController::class, 'ajax'])->name('calenderAjax');

//PENELITIAN
Route::get('plt_profil_penelitian', [PenelitianController::class, 'plt_profil_penelitian'])->name('plt_profil_penelitian');

// Data Penelitian Table (General Research Data)
Route::get('data_penelitian_table', [PenelitianController::class, 'data_penelitian_table'])->name('data_penelitian_table');
Route::post('data_penelitian_table/tambah', [PenelitianController::class, 'tambah_data_penelitian_table'])->name('tambah_data_penelitian_table');
Route::post('data_penelitian_table/edit', [PenelitianController::class, 'edit_data_penelitian_table'])->name('edit_data_penelitian_table');
Route::get('data_penelitian_table/hapus/{id}', [PenelitianController::class, 'hapus_data_penelitian_table'])->name('hapus_data_penelitian_table');
Route::post('data_penelitian_table/import', [PenelitianController::class, 'import_data_penelitian_table'])->name('import_data_penelitian_table');

//Abdimas
// Program Abdimas
Route::get('abdimas_program_abdimas', [AbdimasController::class, 'abdimas_program_abdimas'])->name('abdimas_program_abdimas');

// Data Abdimas Table
Route::get('data_abdimas_table', [AbdimasController::class, 'data_abdimas_table'])->name('data_abdimas_table');
Route::post('data_abdimas_table/tambah_data_abdimas_table', [AbdimasController::class, 'tambah_data_abdimas_table'])->name('tambah_data_abdimas_table');
Route::post('data_abdimas_table/edit_data_abdimas_table', [AbdimasController::class, 'edit_data_abdimas_table'])->name('edit_data_abdimas_table');
Route::get('data_abdimas_table/hapus/{id}', [AbdimasController::class, 'hapus_data_abdimas_table'])->name('hapus_data_abdimas_table');
Route::post('data_abdimas_table/import_data_abdimas_table', [AbdimasController::class, 'import_data_abdimas_table'])->name('import_data_abdimas_table');

//publikasi
// Program & Data Publikasi
Route::get('publikasi_program_publikasi', [PublikasiController::class, 'program_publikasi'])->name('program_publikasi');

// KI (Kekayaan Intelektual)
Route::get('data_ki_table', [KiController::class, 'data_ki_table'])->name('data_ki_table');
Route::post('data_ki_table/tambah_data_ki_table', [KiController::class, 'tambah_data_ki_table'])->name('tambah_data_ki_table');
Route::post('data_ki_table/edit_data_ki_table', [KiController::class, 'edit_data_ki_table'])->name('edit_data_ki_table');
Route::get('data_ki_table/hapus/{id}', [KiController::class, 'hapus_data_ki_table'])->name('hapus_data_ki_table');
Route::post('data_ki_table/import_ki_table', [KiController::class, 'import_ki_table'])->name('import_ki_table');

// Data Publikasi (Table)
Route::get('data_publikasi_table', [PublikasiController::class, 'data_publikasi_table'])->name('data_publikasi_table');
Route::post('data_publikasi_table/tambah_data_publikasi_table', [PublikasiController::class, 'tambah_data_publikasi_table'])->name('tambah_data_publikasi_table');
Route::post('data_publikasi_table/edit_data_publikasi_table', [PublikasiController::class, 'edit_data_publikasi_table'])->name('edit_data_publikasi_table');
Route::get('data_publikasi_table/hapus/{id}', [PublikasiController::class, 'hapus_data_publikasi_table'])->name('hapus_data_publikasi_table');
Route::post('data_publikasi_table/import_publikasi_table', [PublikasiController::class, 'import_publikasi_table'])->name('import_publikasi_table');

// Data Dosen
Route::get('data_dosen_table', [DataDosenController::class, 'data_dosen_table'])->name('data_dosen_table');
Route::post('data_dosen_table/tambah_data_dosen_table', [DataDosenController::class, 'tambah_data_dosen_table'])->name('tambah_data_dosen_table');
Route::post('data_dosen_table/edit_data_dosen_table', [DataDosenController::class, 'edit_data_dosen_table'])->name('edit_data_dosen_table');
Route::get('data_dosen_table/hapus/{id}', [DataDosenController::class, 'hapus_data_dosen_table'])->name('hapus_data_dosen_table');
Route::post('data_dosen_table/import_data_dosen_table', [DataDosenController::class, 'import_data_dosen_table'])->name('import_data_dosen_table');

// Data Mahasiswa
Route::get('data_mahasiswa_table', [DataMahasiswaController::class, 'data_mahasiswa_table'])->name('data_mahasiswa_table');
Route::post('data_mahasiswa_table/tambah_data_mahasiswa_table', [DataMahasiswaController::class, 'tambah_data_mahasiswa_table'])->name('tambah_data_mahasiswa_table');
Route::post('data_mahasiswa_table/edit_data_mahasiswa_table', [DataMahasiswaController::class, 'edit_data_mahasiswa_table'])->name('edit_data_mahasiswa_table');
Route::get('data_mahasiswa_table/hapus/{id}', [DataMahasiswaController::class, 'hapus_data_mahasiswa_table'])->name('hapus_data_mahasiswa_table');
Route::post('data_mahasiswa_table/import_data_mahasiswa_table', [DataMahasiswaController::class, 'import_data_mahasiswa_table'])->name('import_data_mahasiswa_table');

//calender


// admin
Route::get('fullcalender', [AdminController::class, 'index'])->name('admin_fullcalender');
Route::post('fullcalenderAjax', [AdminController::class, 'ajax'])->name('admin_fullcalenderAjax');
