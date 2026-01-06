@extends('layouts.app')

@section('title', 'Daftar Barang Masuk - Sistem Inventory')
@section('icon', '')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-sign-in-alt text-primary me-2"></i>
                Daftar Barang Masuk
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Barang Masuk</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('barang-masuk.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Tambah Barang Masuk
        </a>
    </div>

    <!-- Filter Card -->
    <div class="card shadow border-0 mb-4">
        <div class="card-body">
            <form action="{{ route('barang-masuk.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Tanggal Awal</label>
                    <input type="date" name="start_date" class="form-control" 
                           value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Tanggal Akhir</label>
                    <input type="date" name="end_date" class="form-control" 
                           value="{{ request('end_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Bidang</label>
                    <select name="bidang" class="form-select">
    <option value="">Semua Bidang</option>
    @foreach ($bidang as $b)
        <option value="{{ $b->kode }}"
            {{ request('bidang') == $b->kode ? 'selected' : '' }}>
            {{ $b->nama }}
        </option>
    @endforeach
</select>

                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Filter
                        </button>
                        <a href="{{ route('barang-masuk.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-list me-2"></i>
                Data Barang Masuk
            </h5>
        </div>
        <div class="card-body">
            @if($barangMasuk->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th width="120">Tanggal</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th width="100">Jumlah</th>
                            <th width="150">Harga Satuan</th>
                            <th width="150">Total Nilai</th>
                            <th width="200">Keterangan</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barangMasuk as $item)
                        <tr>
                            <td>{{ $loop->iteration + (($barangMasuk->currentPage() - 1) * $barangMasuk->perPage()) }}</td>
                            <td>
                                <span class="badge bg-light text-dark">
                                    {{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d/m/Y') }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $item->barang->kode_barang ?? '-' }}</span>
                            </td>
                            <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                            <td>
                                <span class="badge bg-primary">
                                    {{ number_format($item->jumlah) }} {{ $item->barang->satuan ?? '' }}
                                </span>
                            </td>
                            <td>
                                Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="fw-bold text-success">
                                    Rp {{ number_format($item->total_nilai, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $item->keterangan ? Str::limit($item->keterangan, 30) : '-' }}
                                </small>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('barang-masuk.show', $item->id) }}" 
                                       class="btn btn-sm btn-info" 
                                       data-bs-toggle="tooltip" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('barang-masuk.edit', $item->id) }}" 
                                       class="btn btn-sm btn-warning"
                                       data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('barang-masuk.destroy', $item->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                data-bs-toggle="tooltip" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $barangMasuk->firstItem() }} - {{ $barangMasuk->lastItem() }} dari {{ $barangMasuk->total() }} data
                </div>
                {{ $barangMasuk->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada data barang masuk</h5>
                <p class="text-muted">Mulai dengan menambahkan barang masuk baru</p>
                <a href="{{ route('barang-masuk.create') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Barang Masuk
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush