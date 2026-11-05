<?php

use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalMitraController;
use App\Http\Controllers\KomplainController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\PaketLayananController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/mitra-menunggu', function () {
        return view('mitra.menunggu');
    })->name('mitra.menunggu');
});

// ==========================================
// ADMIN
// ==========================================
Route::middleware(['auth', 'role:admin'])->prefix('paket-layanan')->name('paket.')->group(function () {
    Route::get('/', [PaketLayananController::class, 'index'])->name('index');
    Route::get('/tambah', [PaketLayananController::class, 'create'])->name('create');
    Route::post('/', [PaketLayananController::class, 'store'])->name('store');
    Route::get('/{paket}/edit', [PaketLayananController::class, 'edit'])->name('edit');
    Route::put('/{paket}', [PaketLayananController::class, 'update'])->name('update');
    Route::delete('/{paket}', [PaketLayananController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('data-mitra')->name('mitra.')->group(function () {
    Route::get('/', [MitraController::class, 'index'])->name('index');
    Route::get('/{mitra}/detail', [MitraController::class, 'detail'])->name('detail');
    Route::post('/{mitra}/verify', [MitraController::class, 'verify'])->name('verify');
    Route::post('/{mitra}/reject', [MitraController::class, 'reject'])->name('reject');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/komplain', [KomplainController::class, 'index'])->name('komplain.index');
    Route::patch('/komplain/{komplain}', [KomplainController::class, 'update'])->name('komplain.update');
    Route::post('/pesanan/{pesanan}/verifikasi-bayar', [PembayaranController::class, 'verify'])->name('pembayaran.verify');
});

// ==========================================
// MITRA
// ==========================================
Route::middleware(['auth', 'role:mitra'])->group(function () {
    Route::get('/jadwal-mitra', [JadwalMitraController::class, 'index'])->name('mitra.jadwal');
    Route::post('/jadwal-mitra', [JadwalMitraController::class, 'update'])->name('mitra.jadwal.update');
    Route::get('/pesanan-masuk', [PesananController::class, 'pesananMasuk'])->name('pesanan.masuk');
    Route::get('/tugas-saya', [PesananController::class, 'tugasSaya'])->name('pesanan.tugasSaya');
    Route::post('/pesanan/{pesanan}/accept', [PesananController::class, 'accept'])->name('pesanan.accept');
    Route::post('/pesanan/{pesanan}/reject', [PesananController::class, 'reject'])->name('pesanan.reject');
    Route::get('/riwayat-mitra', [PesananController::class, 'riwayatMitra'])->name('mitra.riwayat');
    Route::post('/pesanan/{pesanan}/konfirmasi-cod', [PembayaranController::class, 'konfirmasiCod'])->name('pembayaran.konfirmasiCod');
    Route::post('/pesanan/{pesanan}/checklist', [ChecklistController::class, 'update'])->name('pesanan.checklist');
});

// ==========================================
// PELANGGAN
// ==========================================
Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('/katalog', [PesananController::class, 'katalog'])->name('pesanan.katalog');
    Route::get('/paket/{paket}/detail', [PaketLayananController::class, 'show'])->name('pesanan.paketDetail');
    Route::get('/pesanan/{pesanan}/rating', [RatingController::class, 'create'])->name('rating.create');
    Route::post('/pesanan/{pesanan}/rating', [RatingController::class, 'store'])->name('rating.store');
    Route::get('/pesanan/{pesanan}/komplain', [KomplainController::class, 'create'])->name('komplain.create');
    Route::post('/pesanan/{pesanan}/komplain', [KomplainController::class, 'store'])->name('komplain.store');
    Route::post('/pesanan/{pesanan}/batalkan', [PesananController::class, 'batalkan'])->name('pesanan.batalkan');
});

// ==========================================
// SEMUA ROLE (asal sudah login)
// ==========================================
Route::middleware(['auth'])->prefix('pesanan')->name('pesanan.')->group(function () {
    Route::get('/buat', [PesananController::class, 'create'])->name('create');
    Route::post('/', [PesananController::class, 'store'])->name('store');
    Route::get('/riwayat', [PesananController::class, 'riwayat'])->name('riwayat');
    Route::get('/{pesanan}/detail', [PesananController::class, 'detail'])->name('detail');
    Route::patch('/{pesanan}/status', [PesananController::class, 'updateStatus'])->name('updateStatus');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/pesanan/{pesanan}/bayar', [PembayaranController::class, 'create'])->name('pembayaran.create');
    Route::post('/pesanan/{pesanan}/bayar', [PembayaranController::class, 'store'])->name('pembayaran.store');
    Route::get('/pesanan/{pesanan}/nota', [PembayaranController::class, 'nota'])->name('pembayaran.nota');
});

require __DIR__.'/auth.php';
