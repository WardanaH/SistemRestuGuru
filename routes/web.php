<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CabangController;

// Guest (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Authenticated (sudah login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Sistem
    Route::middleware(['role:admin|direktur|manajemen|supervisor'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('cabangs', CabangController::class);
        Route::resource('roles', RoleController::class)->only(['index', 'store', 'update', 'destroy']);
    });
});
