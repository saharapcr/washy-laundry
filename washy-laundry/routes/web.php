<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    return redirect()->route(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'beranda');
});

// LOGIN & REGISTER
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// PELANGGAN
Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('/beranda', [CustomerController::class, 'beranda'])->name('beranda');
    Route::get('/kalkulator', [CustomerController::class, 'kalkulator'])->name('kalkulator');
    Route::get('/pesanan/buat', [CustomerController::class, 'buat'])->name('pesanan.buat');
    Route::post('/pesanan/buat', [CustomerController::class, 'simpan'])->name('pesanan.simpan');
    Route::get('/lacak', [CustomerController::class, 'lacak'])->name('lacak');
    Route::get('/riwayat', [CustomerController::class, 'riwayat'])->name('riwayat');
    Route::get('/profil', [CustomerController::class, 'profil'])->name('profil');
    Route::put('/profil', [CustomerController::class, 'updateProfil'])->name('profil.update');
});

// ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/pesanan', [AdminController::class, 'pesanan'])->name('pesanan');
    Route::get('/pesanan/{pesanan}', [AdminController::class, 'detail'])->name('pesanan.detail');
    Route::put('/pesanan/{pesanan}/status', [AdminController::class, 'updateStatus'])->name('pesanan.status');

    Route::get('/layanan', [ServiceController::class, 'index'])->name('layanan');
    Route::post('/layanan', [ServiceController::class, 'store'])->name('layanan.simpan');
    Route::put('/layanan/{layanan}', [ServiceController::class, 'update'])->name('layanan.update');

    Route::get('/pembayaran', [AdminController::class, 'pembayaran'])->name('pembayaran');
    Route::put('/pembayaran/{pembayaran}', [AdminController::class, 'konfirmasi'])->name('pembayaran.konfirmasi');

    Route::get('/pelanggan', [AdminController::class, 'pelanggan'])->name('pelanggan');
});
