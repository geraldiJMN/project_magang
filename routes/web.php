<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ManajemenProdukController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\ManajemenPesananController;
use App\Http\Controllers\Admin\ManajemenPenggunaController;
use App\Http\Controllers\Admin\ManajemenUlasanController;
use App\Http\Controllers\Admin\ManajemenStokController;
use App\Http\Controllers\Admin\NotifikasiAdminController;

// Untuk admin (gunakan prefix dan middleware jika perlu)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('produk', ManajemenProdukController::class);

    Route::get('promo/create/{kopi_id}', [PromoController::class, 'create'])->name('promo.createByKopi');
    Route::get('promo/show-by-kopi/{kopi_id}', [PromoController::class, 'showByKopi'])->name('promo.showByKopi');
    Route::resource('promo', PromoController::class)->except(['create', 'show']);
    Route::get('promo/{kopi_id}', [PromoController::class, 'show'])->name('promo.show');


    Route::resource('pesanan', ManajemenPesananController::class);
    Route::put('pesanan/{id}/status', [ManajemenPesananController::class, 'updateStatus'])->name('pesanan.updateStatus');

    Route::resource('pengguna', \App\Http\Controllers\Admin\ManajemenPenggunaController::class)->only(['index', 'show', 'destroy']);

    // Route resource utama untuk ulasan
    Route::resource('ulasan', \App\Http\Controllers\Admin\ManajemenUlasanController::class)->only(['index', 'update', 'destroy']);

    Route::resource('stok', ManajemenStokController::class)->only(['index', 'edit', 'update']);

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('notifikasi', [NotifikasiAdminController::class, 'index'])->name('notifikasi');
});

// Tambahkan ini untuk testing: akses langsung ke dashboard
Route::get('/', [DashboardController::class, 'index']);
