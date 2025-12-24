@extends('layouts.app')

@section('title', 'Detail Barang Masuk - Sistem Inventory')
@section('icon', 'fa-eye')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-eye text-primary me-2"></i>
                Detail Barang Masuk
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('barang-masuk.index') }}">Barang Masuk</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('barang-masuk.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <a href="{{ route('barang-masuk.edit', $barangMasuk->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-info-circle me-2"></i>
                        Informasi Barang Masuk
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Tanggal Masuk</label>
                                <div class="fw-semibold">
                                    <i class="fas fa-calendar me-2 text-primary"></i>
                                    {{ \Carbon\Carbon::parse($barangMasuk->tanggal_masuk)->format('d F Y') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Jumlah</label>
                                <div class="fw-semibold">
                                    <i class="fas fa-boxes me-2 text-primary"></i>
                                    {{ number_format($barangMasuk->jumlah) }} {{ $barangMasuk->barang->satuan ?? '' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Harga Satuan</label>
                                <div class="fw-semibold text-success">
                                    <i class="fas fa-money-bill-wave me-2"></i>
                                    Rp {{ number_format($barangMasuk->harga_satuan, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Total Nilai</label>
                                <div class="fw-bold text-success fs-5">
                                    <i class="fas fa-calculator me-2"></i>
                                    Rp {{ number_format($barangMasuk->total_nilai, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label text-muted">Keterangan</label>
                                <div class="p-3 bg-light rounded">
                                    {{ $barangMasuk->keterangan ?? 'Tidak ada keterangan' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-box me-2"></i>
                        Informasi Barang
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted">Kode Barang</label>
                        <div class="fw-bold">
                            <i class="fas fa-barcode me-2"></i>
                            {{ $barangMasuk->barang->kode_barang ?? '-' }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Nama Barang</label>
                        <div class="fw-semibold">
                            <i class="fas fa-box-open me-2"></i>
                            {{ $barangMasuk->barang->nama_barang ?? '-' }}
                        </div>
                    </div>
<div class="mb-3">
    <label class="form-label text-muted">Jenis Barang</label>
    <div>
        @if(optional($barangMasuk->barang)->jenis_barang === 'pakai_habis')
            <span class="badge bg-info">
                <i class="fas fa-sync-alt me-1"></i> Pakai Habis
            </span>
        @elseif(optional($barangMasuk->barang)->jenis_barang === 'aset_tetap')
            <span class="badge bg-success">
                <i class="fas fa-lock me-1"></i> Aset Tetap
            </span>
        @else
            <span class="badge bg-secondary">
                Tidak Diketahui
            </span>
        @endif
    </div>
</div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Bidang</label>
                        <div>
                            <i class="fas fa-building me-2"></i>
                            {{ $barangMasuk->barang->bidang->nama_bidang ?? '-' }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Stok Saat Ini</label>
                        <div class="fw-bold">
                            <i class="fas fa-database me-2"></i>
                            {{ number_format($barangMasuk->barang->stok ?? 0) }} {{ $barangMasuk->barang->satuan ?? '' }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Ditambahkan Oleh</label>
                        <div>
                            <i class="fas fa-user me-2"></i>
                            {{ $barangMasuk->user->name ?? '-' }}
                            <br>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($barangMasuk->created_at)->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection