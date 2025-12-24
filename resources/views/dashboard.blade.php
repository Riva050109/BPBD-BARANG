@extends('layouts.app')

@section('title', 'Dashboard')
@section('icon', '')

@section('content')
<!-- Statistics Cards -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card bg-gradient-primary text-white shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                            Total Barang
                        </div>
                        <div class="h2 mb-0 font-weight-bold">{{ $totalBarang ?? 0 }}</div>
                        <div class="mt-2">
                            <small><i class="fas fa-box me-1"></i> Semua jenis barang</small>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-boxes fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card bg-gradient-info text-white shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                            Barang Masuk
                        </div>
                        <div class="h2 mb-0 font-weight-bold">{{ $totalMasuk ?? 0 }}</div>
                        <div class="mt-2">
                            <small><i class="fas fa-arrow-down me-1"></i> Transaksi masuk</small>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-arrow-down fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card bg-gradient-warning text-white shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                            Barang Keluar
                        </div>
                        <div class="h2 mb-0 font-weight-bold">{{ $totalKeluar ?? 0 }}</div>
                        <div class="mt-2">
                            <small><i class="fas fa-arrow-up me-1"></i> Transaksi keluar</small>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-arrow-up fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 text-dark">
                    <i class="fas fa-bolt text-warning me-2"></i>Akses Cepat
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-xl-3 col-md-6">
                        <a href="{{ route('barang.index') }}" class="card action-card text-decoration-none h-100">
                            <div class="card-body text-center p-4">
                                <div class="icon-wrapper bg-primary rounded-circle mx-auto mb-3">
                                    <i class="fas fa-box fa-2x text-white"></i>
                                </div>
                                <h6 class="font-weight-bold text-dark mb-2">Kartu Barang</h6>
                                <p class="text-muted small mb-0">Kelola data master barang</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <a href="{{ route('barang-masuk.index') }}" class="card action-card text-decoration-none h-100">
                            <div class="card-body text-center p-4">
                                <div class="icon-wrapper bg-success rounded-circle mx-auto mb-3">
                                    <i class="fas fa-arrow-down fa-2x text-white"></i>
                                </div>
                                <h6 class="font-weight-bold text-dark mb-2">Barang Masuk</h6>
                                <p class="text-muted small mb-0">Input penerimaan barang</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <a href="{{ route('barang-keluar.index') }}" class="card action-card text-decoration-none h-100">
                            <div class="card-body text-center p-4">
                                <div class="icon-wrapper bg-warning rounded-circle mx-auto mb-3">
                                    <i class="fas fa-arrow-up fa-2x text-white"></i>
                                </div>
                                <h6 class="font-weight-bold text-dark mb-2">Barang Keluar</h6>
                                <p class="text-muted small mb-0">Input pengeluaran barang</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <a href="{{ route('laporan.saldo-awal') }}" class="card action-card text-decoration-none h-100">
                            <div class="card-body text-center p-4">
                                <div class="icon-wrapper bg-info rounded-circle mx-auto mb-3">
                                    <i class="fas fa-file-alt fa-2x text-white"></i>
                                </div>
                                <h6 class="font-weight-bold text-dark mb-2">Laporan</h6>
                                <p class="text-muted small mb-0">Lihat laporan stok</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- System Status -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>Status Sistem
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 mb-3">
                        <div class="border rounded p-3">
                            <i class="fas fa-database fa-2x text-primary mb-2"></i>
                            <h6 class="font-weight-bold">Database</h6>
                            <span class="badge bg-success">Online</span>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="border rounded p-3">
                            <i class="fas fa-server fa-2x text-info mb-2"></i>
                            <h6 class="font-weight-bold">Server</h6>
                            <span class="badge bg-success">Stabil</span>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="border rounded p-3">
                            <i class="fas fa-shield-alt fa-2x text-success mb-2"></i>
                            <h6 class="font-weight-bold">Keamanan</h6>
                            <span class="badge bg-success">Aman</span>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="border rounded p-3">
                            <i class="fas fa-sync-alt fa-2x text-warning mb-2"></i>
                            <h6 class="font-weight-bold">Update</h6>
                            <span class="badge bg-success">Terbaru</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.action-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border: 1px solid #e3e6f0;
}

.action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    border-color: #dc3545;
}

.icon-wrapper {
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
}

.bg-gradient-danger {
    background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%);
}

.bg-gradient-secondary {
    background: linear-gradient(135deg, #858796 0%, #60616f 100%);
}

.bg-gradient-dark {
    background: linear-gradient(135deg, #5a5c69 0%, #373840 100%);
}

.card {
    border: none;
    border-radius: 10px;
}
</style>
@endsection