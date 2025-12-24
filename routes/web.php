<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BAPenyerahanController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\BidangController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DataEntryController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// ======================
// AUTHENTICATION
// ======================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/home', [DashboardController::class, 'index'])->name('home'); // 👈 TAMBAH INI

// ======================   
// AUTH MIDDLEWARE
// ======================
Route::middleware(['auth'])->group(function () {

    // ======================
    // DASHBOARD
    // ======================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ======================
    // ADMIN ROUTES
    // ======================
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    });

    // ======================
    // MASTER DATA
    // ======================
    Route::get('/master-data', [MasterDataController::class, 'index'])->name('master-data.index');

    // ======================
    // BIDANG
    // ======================
    Route::prefix('bidang')->name('bidang.')->group(function () {
        Route::get('/', [BidangController::class, 'index'])->name('index');
        Route::get('/{kode}', [BidangController::class, 'show'])->name('show');
        Route::get('/{kode}/export', [BidangController::class, 'export'])->name('export');
        Route::get('/{kode}/print', [BidangController::class, 'print'])->name('print');
        Route::get('/{kode}/barang', [BidangController::class, 'getBarang'])->name('barang');
    });

    // ======================
    // DATA ENTRY
    // ======================
    Route::prefix('data-entry')->name('data-entry.')->group(function () {
        Route::get('/', [DataEntryController::class, 'index'])->name('index');
        Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
        Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barang-masuk.index');
        Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barang-keluar.index');
        Route::get('/barang/{id}', [BarangController::class, 'show'])->name('barang.show');
    });

    // ======================
    // BARANG
    // ======================
    Route::prefix('barang')->name('barang.')->group(function () {
        Route::get('/', [BarangController::class, 'index'])->name('index');
        Route::get('/create', [BarangController::class, 'create'])->name('create');
        Route::post('/', [BarangController::class, 'store'])->name('store');
        Route::get('/{id}', [BarangController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [BarangController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BarangController::class, 'update'])->name('update');
        Route::delete('/{id}', [BarangController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/kartu', [BarangController::class, 'kartuBarang'])->name('kartu');
        Route::get('/{id}/kartu/print', [BarangController::class, 'kartuBarangPrint'])->name('kartu.print');
        Route::get('/export', [BarangController::class, 'export'])->name('export');
        Route::get('/import', [BarangController::class, 'importForm'])->name('import.form');
        Route::post('/import', [BarangController::class, 'import'])->name('import');
    });

    // ======================
    // BARANG MASUK
    // ======================
// Barang Masuk Routes
Route::prefix('barang-masuk')->name('barang-masuk.')->group(function () {
    Route::get('/', [BarangMasukController::class, 'index'])->name('index');
    Route::get('/create', [BarangMasukController::class, 'create'])->name('create');
    Route::post('/', [BarangMasukController::class, 'store'])->name('store');
    Route::get('/{id}', [BarangMasukController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [BarangMasukController::class, 'edit'])->name('edit');
    Route::put('/{id}', [BarangMasukController::class, 'update'])->name('update');
    Route::delete('/{id}', [BarangMasukController::class, 'destroy'])->name('destroy');
});

    // ======================
    // BARANG KELUAR
    // ======================
    Route::prefix('barang-keluar')->name('barang-keluar.')->group(function () {
        Route::get('/', [BarangKeluarController::class, 'index'])->name('index');
        Route::get('/create', [BarangKeluarController::class, 'create'])->name('create');
        Route::post('/', [BarangKeluarController::class, 'store'])->name('store');
        Route::get('/{id}', [BarangKeluarController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [BarangKeluarController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BarangKeluarController::class, 'update'])->name('update');
        Route::delete('/{id}', [BarangKeluarController::class, 'destroy'])->name('destroy');
        Route::get('/export', [BarangKeluarController::class, 'export'])->name('export');
        Route::get('/print/{id}', [BarangKeluarController::class, 'print'])->name('print');
    });

    // ======================
    // BA PENYERAHAN
    // ======================
    Route::prefix('ba-penyerahan')->name('ba-penyerahan.')->group(function () {
        Route::get('/', [BAPenyerahanController::class, 'index'])->name('index');
        Route::get('/create', [BAPenyerahanController::class, 'create'])->name('create');
        Route::post('/', [BAPenyerahanController::class, 'store'])->name('store');
        Route::get('/{id}', [BAPenyerahanController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [BAPenyerahanController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BAPenyerahanController::class, 'update'])->name('update');
        Route::delete('/{id}', [BAPenyerahanController::class, 'destroy'])->name('destroy');
        Route::get('/export', [BAPenyerahanController::class, 'export'])->name('export');
        Route::get('/print/{id}', [BAPenyerahanController::class, 'print'])->name('print');
        Route::get('/{id}/pdf', [BAPenyerahanController::class, 'generatePDF'])->name('pdf');
    });

    // ======================
    // LAPORAN
    // ======================
   Route::middleware(['admin'])->prefix('laporan')->name('laporan.')->group(function () {
        // Stok
        Route::get('/stok', [LaporanController::class, 'laporanStok'])->name('stok');
        Route::get('/stok/export', [LaporanController::class, 'exportStok'])->name('stok.export');
        Route::get('/stok/print', [LaporanController::class, 'printStok'])->name('stok.print');
        
        // Rekap Masuk
        Route::get('/rekap-masuk', [LaporanController::class, 'rekapMasuk'])->name('rekap-masuk');
        Route::get('/rekap-masuk/export', [LaporanController::class, 'exportRekapMasuk'])->name('rekap-masuk.export');
        Route::get('/rekap-masuk/print', [LaporanController::class, 'printRekapMasuk'])->name('rekap-masuk.print');
        
        // Rekap Keluar
        Route::get('/rekap-keluar', [LaporanController::class, 'rekapKeluar'])->name('rekap-keluar');
        Route::get('/rekap-keluar/export', [LaporanController::class, 'exportRekapKeluar'])->name('rekap-keluar.export');
        Route::get('/rekap-keluar/print', [LaporanController::class, 'printRekapKeluar'])->name('rekap-keluar.print');
        
        // Saldo Awal
        Route::get('/saldo-awal', [LaporanController::class, 'saldoAwal'])->name('saldo-awal');
        Route::get('/saldo-awal/export', [LaporanController::class, 'exportSaldoAwal'])->name('saldo-awal.export');
        Route::get('/saldo-awal/print', [LaporanController::class, 'printSaldoAwal'])->name('saldo-awal.print');
        
        // BA Penyerahan
        Route::get('/ba-penyerahan', [LaporanController::class, 'laporanBAPenyerahan'])->name('ba-penyerahan');
        Route::get('/ba-penyerahan/export', [LaporanController::class, 'exportBAPenyerahan'])->name('ba-penyerahan.export');
        Route::get('/ba-penyerahan/print', [LaporanController::class, 'printBAPenyerahan'])->name('ba-penyerahan.print');
        
        // Mutasi Barang
        Route::get('/mutasi', [LaporanController::class, 'mutasiBarang'])->name('mutasi');
        Route::get('/mutasi/export', [LaporanController::class, 'exportMutasi'])->name('mutasi.export');
        
        // Dashboard Laporan
        Route::get('/', [LaporanController::class, 'index'])->name('index');
    });

    // ======================
    // MASTER DATA - SATUAN & JENIS BARANG
    // ======================
    Route::prefix('satuan')->name('satuan.')->group(function () {
        Route::get('/', [SatuanController::class, 'index'])->name('index');
        Route::get('/create', [SatuanController::class, 'create'])->name('create');
        Route::post('/', [SatuanController::class, 'store'])->name('store');
        Route::get('/{id}', [SatuanController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [SatuanController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SatuanController::class, 'update'])->name('update');
        Route::delete('/{id}', [SatuanController::class, 'destroy'])->name('destroy');
        Route::get('/export', [SatuanController::class, 'export'])->name('export');
    });

    Route::prefix('jenis-barang')->name('jenis-barang.')->group(function () {
        Route::get('/', [JenisBarangController::class, 'index'])->name('index');
        Route::get('/create', [JenisBarangController::class, 'create'])->name('create');
        Route::post('/', [JenisBarangController::class, 'store'])->name('store');
        Route::get('/{id}', [JenisBarangController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [JenisBarangController::class, 'edit'])->name('edit');
        Route::put('/{id}', [JenisBarangController::class, 'update'])->name('update');
        Route::delete('/{id}', [JenisBarangController::class, 'destroy'])->name('destroy');
        Route::get('/export', [JenisBarangController::class, 'export'])->name('export');
    });

    // ======================
    // USERS (Admin only)
    // ======================
    Route::middleware(['admin'])->prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/reset-password', [UserController::class, 'resetPassword'])->name('reset-password');
        Route::get('/export', [UserController::class, 'export'])->name('export');
    });

    // ======================
    // AJAX & API Routes
    // ======================
    Route::prefix('api')->name('api.')->group(function () {
        // API untuk generate kode barang
        Route::post('/generate-kode', [BarangController::class, 'generateKode'])->name('generate.kode');
        Route::get('/barang/{id}/detail', [BarangController::class, 'getDetail'])->name('barang.detail');
        
        // Get barang by bidang
        Route::get('/bidang/{kode}/barang', [BidangController::class, 'getBarangApi'])->name('bidang.barang');
        
        // Get barang for dropdown
        Route::get('/barang-list', [BarangController::class, 'getBarangList'])->name('barang.list');
        
        // Get jenis barang
        Route::get('/jenis-barang', [JenisBarangController::class, 'getJenisBarang'])->name('jenis-barang');
        
        // Get satuan
        Route::get('/satuan', [SatuanController::class, 'getSatuan'])->name('satuan');
        
        // Dashboard stats
        Route::get('/dashboard/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');
        
        // Laporan data
        Route::get('/laporan/stok', [LaporanController::class, 'getStokData'])->name('laporan.stok-data');
    });

    // ======================
    // UTILITY ROUTES
    // ======================
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile');

    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings');

    Route::get('/help', function () {
        return view('help.index');
    })->name('help');

    // ======================
    // FALLBACK ROUTE
    // ======================
    Route::fallback(function () {
        return view('errors.404');
    });


    Route::get('/api/barang/by-kode/{kode}', [BarangController::class, 'getByKode'])
    ->name('api.barang.by-kode');

});