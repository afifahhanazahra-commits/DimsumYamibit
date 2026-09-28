<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\StokController as AdminStokController;
use App\Http\Controllers\Admin\ToppingController as AdminToppingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Dimsum Yamibit
|--------------------------------------------------------------------------
*/

// =======================
// FRONT-END PELANGGAN (Login-less)
// =======================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [OrderController::class, 'store'])->name('order.store');
Route::get('/pesanan/{kode_pesanan}', [OrderController::class, 'show'])->name('order.status');
Route::post('/pesanan/{kode_pesanan}/reupload', [OrderController::class, 'reuploadBukti'])->name('order.reupload');
Route::get('/pesanan/{kode_pesanan}/struk', [OrderController::class, 'printStruk'])->name('order.struk');

// =======================
// ADMIN AUTHENTICATION
// =======================
Route::get('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'authenticate'])->name('admin.authenticate');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// =======================
// BACK-END ADMIN DASHBOARD (Protected)
// =======================
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index']);
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Manajemen Pesanan
    Route::get('/pesanan', [AdminOrderController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [AdminOrderController::class, 'show'])->name('pesanan.show');
    Route::post('/pesanan/{id}/verify', [AdminOrderController::class, 'verifyPayment'])->name('pesanan.verify');
    Route::post('/pesanan/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('pesanan.updateStatus');
    Route::get('/pesanan/{id}/struk', [AdminOrderController::class, 'printStruk'])->name('pesanan.struk');

    // Manajemen Katalog Menu
    Route::resource('menu', AdminMenuController::class);

    // Manajemen Varian Topping/Saus
    Route::resource('topping', AdminToppingController::class);

    // Manajemen Stok Real-Time
    Route::get('/stok', [AdminStokController::class, 'index'])->name('stok.index');
    Route::post('/stok/{id}', [AdminStokController::class, 'update'])->name('stok.update');

    // Laporan Penjualan & Rekapitulasi Keuangan
    Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak-pdf', [AdminLaporanController::class, 'printPdf'])->name('laporan.print');
    Route::get('/laporan/export-csv', [AdminLaporanController::class, 'exportCsv'])->name('laporan.csv');

    // Pengaturan Operasional Toko (Buka / Tutup / Jam Kerja)
    Route::get('/pengaturan', [AdminSettingController::class, 'index'])->name('pengaturan.index');
    Route::post('/pengaturan', [AdminSettingController::class, 'update'])->name('pengaturan.update');
    Route::post('/pengaturan/quick-toggle', [AdminSettingController::class, 'quickToggle'])->name('pengaturan.quickToggle');
});
