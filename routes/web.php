<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RayonController;
use App\Http\Controllers\JemaatController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KartuKeluargaController;

// --- GUEST ROUTES ---
Route::prefix('auth')->middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('auth.login');
    Route::post('/login', 'login')->name('auth.login.submit');
    Route::get('/register', 'showRegister')->name('auth.register');
    Route::post('/register', 'register')->name('auth.register.submit');
});

// --- AUTHENTICATED ROUTES ---
Route::middleware('auth')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Resource 
    Route::resource('users', UserController::class)->names([
        'index'   => 'users.index',
        'create'  => 'users.create',
        'store'   => 'users.store',
        'edit'    => 'users.edit',
        'update'  => 'users.update',
        'destroy' => 'users.destroy',
    ]);

    Route::resource('rayons', RayonController::class)->names([
        'index'   => 'rayons.index',
        'create'  => 'rayons.create',
        'store'   => 'rayons.store',
        'show'    => 'rayons.show',
        'edit'    => 'rayons.edit',
        'update'  => 'rayons.update',
        'destroy' => 'rayons.destroy',
    ]);

    Route::resource('kartu-keluarga', KartuKeluargaController::class)->names([
        'index'   => 'kartu-keluarga.index',
        'create'  => 'kartu-keluarga.create',
        'store'   => 'kartu-keluarga.store',
        'show'    => 'kartu-keluarga.show',
        'edit'    => 'kartu-keluarga.edit',
        'update'  => 'kartu-keluarga.update',
        'destroy' => 'kartu-keluarga.destroy',
    ]);

    Route::resource('jemaats', JemaatController::class)->names([
        'index'   => 'jemaats.index',
        'create'  => 'jemaats.create',
        'store'   => 'jemaats.store',
        'show'    => 'jemaats.show',
        'edit'    => 'jemaats.edit',
        'update'  => 'jemaats.update',
        'destroy' => 'jemaats.destroy',
    ]);

    Route::get('/jemaats/export/pdf', [JemaatController::class, 'exportPdf'])->name('jemaats.export.pdf');
    Route::get('/jemaats/export/xls', [JemaatController::class, 'exportXls'])->name('jemaats.export.xls');
});

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/login', function () {
    return redirect()->route('auth.login');
})->name('login');

// --- API ROUTES ---
Route::prefix('/api')->group(function () {
    Route::get('/regencies/{province_id}', [WilayahController::class, 'getRegencies']);
    Route::get('/districts/{regency_id}', [WilayahController::class, 'getDistricts']);
    Route::get('/villages/{district_id}', [WilayahController::class, 'getVillages']);
});
