<?php

use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\PengurusController;
use App\Http\Controllers\Admin\PerlombaanController;
use App\Http\Controllers\Admin\PertandinganController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\VerifikasiPenggunaController;
use App\Http\Controllers\Admin\WasitController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PerlombaanUserController;
use App\Http\Controllers\ProfileUserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/atlet', [HomeController::class, 'atlet']);
Route::get('/wasit', [HomeController::class, 'wasit']);
Route::get('/pengurus', [HomeController::class, 'pengurus']);
Route::get('/berita', [HomeController::class, 'berita'])->name('berita');
Route::get('/berita/{slug}', [HomeController::class, 'detailBerita'])->name('detail-berita');


Route::prefix('pages/admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('0.dashboard');

        // Berita
        Route::resource('berita', BeritaController::class);
        Route::post('/hapus/berita', [BeritaController::class, 'destroy'])->name('0.delete.berita');

        // Perlombaan
        Route::get('/perlombaan', [PerlombaanController::class, 'index'])->name('0.perlombaan');
        Route::post('/tambah/perlombaan', [PerlombaanController::class, 'store'])->name('0.perlombaan.store');
        Route::get('/show/perlombaan/{id}', [PerlombaanController::class, 'show'])->name('0.show.perlombaan');
        Route::post('/update/perlombaan', [PerlombaanController::class, 'update'])->name('0.update.perlombaan');
        Route::post('/hapus/perlombaan', [PerlombaanController::class, 'destroy'])->name('0.delete.perlombaan');
        Route::post('/create/random/pertandingan', [PerlombaanController::class, 'create_random_pertandingan'])->name('0.create.random.pertandingan');
        
        // Pertandingan
        Route::get('/pertandingan', [PertandinganController::class, 'index'])->name('0.pertandingan.index');

        Route::resource('perlombaan-admin', PerlombaanController::class);
        // Wasit
        Route::get('/wasit', [WasitController::class, 'index'])->name('0.wasit');
        Route::post('/tambah/wasit', [WasitController::class, 'store'])->name('0.wasit.store');
        Route::post('/show/wasit', [WasitController::class, 'show'])->name('0.show.wasit');
        Route::post('/update/wasit', [WasitController::class, 'update'])->name('0.update.wasit');
        Route::post('/hapus/wasit', [WasitController::class, 'destroy'])->name('0.delete.wasit');
        
        // Verifikasi
        Route::get('/verifikasi', [VerifikasiPenggunaController::class, 'index'])->name('0.get.verifikasi');
        Route::get('/verifikasi/detail/{id}', [VerifikasiPenggunaController::class, 'show'])->name('0.detail.verifikasi');
        Route::post('/verifikasi', [VerifikasiPenggunaController::class, 'update'])->name('0.verifikasi');
        Route::post('/verifikasi/tolak', [VerifikasiPenggunaController::class, 'tolakVerifikasi'])->name('0.tolak.verifikasi');

        Route::post('/pengurus/hapus', [PengurusController::class, 'destroy'])->name('0.hapus.pengurus');


        Route::get('/pengguna', [PenggunaController::class, 'index'])->name('0.pengguna');
        Route::post('/pengguna/blokir', [PenggunaController::class, 'blokir'])->name('0.blokir.pengguna');
        
        Route::resource('akun-admin', ProfileController::class);
        Route::resource('pengurus', PengurusController::class);
    });

Route::prefix('pages/user')
    ->middleware(['auth', 'user'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('1.dashboard');

        Route::get('/download/kartu/{nama}', [PerlombaanUserController::class, 'downloadKartu'])->name('1.download.kartu');
        Route::get('/perlombaan/{id}/daftar', [PerlombaanUserController::class, 'daftar'])->name('1.daftar');
        Route::resource('perlombaan', PerlombaanUserController::class);
        Route::resource('akun', ProfileUserController::class);
    });


Auth::routes();

