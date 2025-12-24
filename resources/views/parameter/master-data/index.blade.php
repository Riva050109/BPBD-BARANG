@extends('layouts.app')

@section('title', 'Master Data - Sistem Inventory')
@section('icon', '')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-database text-primary me-2"></i>
                Master Data
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active">Master Data</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row g-4">
        <!-- Satuan -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start-primary border-start-3 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-primary fw-semibold mb-2">Satuan Barang</div>
                            <a href="{{ route('satuan.index') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>Lihat Data
                            </a>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-balance-scale fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jenis Barang -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start-success border-start-3 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-success fw-semibold mb-2">Jenis Barang</div>
                            <a href="{{ route('jenis-barang.index') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-eye me-1"></i>Lihat Data
                            </a>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-success bg-opacity-10 text-success">
                                <i class="fas fa-tags fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kategori Barang -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start-warning border-start-3 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-warning fw-semibold mb-2">Kategori Barang</div>
                            <a href="{{ route('kategori-barang.index') }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-eye me-1"></i>Lihat Data
                            </a>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-layer-group fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bidang -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start-info border-start-3 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-info fw-semibold mb-2">Bidang</div>
                            <a href="{{ route('bidang.index') }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye me-1"></i>Lihat Data
                            </a>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-info bg-opacity-10 text-info">
                                <i class="fas fa-sitemap fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-circle {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.border-start-3 {
    border-left-width: 3px !important;
}

.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
</style>
@endsection