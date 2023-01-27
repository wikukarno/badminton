<?php

use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\PerlombaanController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\WasitController;
use App\Http\Controllers\User\DashboardUserController;
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

Route::prefix('pages/admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('0.dashboard');

        // Perlombaan
        Route::get('/perlombaan', [PerlombaanController::class, 'index'])->name('0.perlombaan');
        Route::post('/tambah/perlombaan', [PerlombaanController::class, 'store'])->name('0.perlombaan.store');
        Route::post('/show/perlombaan', [PerlombaanController::class, 'show'])->name('0.show.perlombaan');
        Route::post('/update/perlombaan', [PerlombaanController::class, 'update'])->name('0.update.perlombaan');
        Route::post('/hapus/perlombaan', [PerlombaanController::class, 'destroy'])->name('0.delete.perlombaan');
        
        // Perlombaan
        Route::get('/wasit', [WasitController::class, 'index'])->name('0.wasit');
        Route::post('/tambah/wasit', [WasitController::class, 'store'])->name('0.wasit.store');
        Route::post('/show/wasit', [WasitController::class, 'show'])->name('0.show.wasit');
        Route::post('/update/wasit', [WasitController::class, 'update'])->name('0.update.wasit');
        Route::post('/hapus/wasit', [WasitController::class, 'destroy'])->name('0.delete.wasit');

        Route::get('/pengguna', [PenggunaController::class, 'index'])->name('0.pengguna');
        Route::get('/akun', [ProfileController::class, 'index'])->name('0.akun');
        Route::post('/get-akun', [ProfileController::class, 'show'])->name('0.get-akun');
        Route::post('/akun/update', [ProfileController::class, 'update'])->name('0.update-akun');
        Route::post('/ubah-foto', [ProfileController::class, 'ubahFoto'])->name('0.ubah-foto');
    });

Route::prefix('dashboard/user')
    ->middleware(['auth', 'user'])
    ->group(function () {
        Route::get('/', [DashboardUserController::class, 'index'])->name('user.dashboard');
    });


Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
