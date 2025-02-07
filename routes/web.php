<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\A1Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardApiController;
use App\Http\Controllers\TimbanganPerBagController;
use App\Http\Controllers\TimbanganPerJamController;
use App\Http\Controllers\LaporanPerTanggalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'process'])->name('login_process');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('welcome');
})->name('dashboard')->middleware(['auth']);

Route::get('dashboard_api', DashboardApiController::class)->name('dashboard_api');
Route::get('timbangan_per_bag/{context}', TimbanganPerBagController::class)->name('timbangan_per_bag')->middleware(['auth']);
Route::get('timbangan_per_jam/{context}', [TimbanganPerJamController::class, 'index'])->name('timbangan_per_jam')->middleware(['auth']);
Route::get('laporan_per_tanggal/', [LaporanPerTanggalController::class, 'index'])->name('laporan_per_tanggal.index')->middleware(['auth']);
Route::get('laporan_per_tanggal/{from}/{to}', [LaporanPerTanggalController::class, 'data'])->name('laporan_per_tanggal.data')->middleware(['auth']);
