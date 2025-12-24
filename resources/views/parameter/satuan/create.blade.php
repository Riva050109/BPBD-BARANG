@extends('layouts.app')

@section('title', 'Tambah Satuan')
@section('icon', 'fas fa-balance-scale')

@section('content')
<div class="container-fluid px-3 px-md-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-balance-scale text-primary me-2"></i>
                Tambah Satuan
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('satuan.index') }}">Satuan</a>
                    </li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('satuan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <!-- Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-plus-circle me-2"></i>Form Tambah Satuan
            </h5>
        </div>

        <form action="{{ route('satuan.store') }}" method="POST">
            @csrf

            <div class="card-body">
                <div class="row g-3">

                    <!-- Nama Satuan -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Nama Satuan <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="nama_satuan"
                               class="form-control @error('nama_satuan') is-invalid @enderror"
                               value="{{ old('nama_satuan') }}"
                               placeholder="Contoh: Pcs, Unit, Set"
                               required>

                        @error('nama_satuan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Keterangan -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Keterangan</label>
                        <input type="text"
                               name="keterangan"
                               class="form-control"
                               value="{{ old('keterangan') }}"
                               placeholder="Opsional">
                    </div>

                </div>
            </div>

            <div class="card-footer bg-white text-end">
                <button type="reset" class="btn btn-outline-secondary">
                    <i class="fas fa-undo me-1"></i>Reset
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
