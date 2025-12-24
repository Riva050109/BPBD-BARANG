@extends('layouts.app')

@section('title', 'Jenis Barang - Sistem Inventory')
@section('icon', '')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Header dengan Breadcrumb -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-tags text-primary me-2"></i>
                Jenis Barang
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('master-data') }}" class="text-decoration-none">Master Data</a></li>
                    <li class="breadcrumb-item active">Jenis Barang</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('jenis-barang.export') }}" class="btn btn-outline-success me-2">
                <i class="fas fa-file-excel me-1"></i>Export
            </a>
            <a href="{{ route('jenis-barang.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus-circle me-2"></i>Tambah Jenis
            </a>
        </div>
    </div>

    <!-- Statistik Card -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-start-primary border-start-3 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-primary fw-semibold mb-1">Total Jenis</div>
                            <div class="h2 mb-0 fw-bold">{{ $jenisBarang->count() }}</div>
                            <div class="small text-muted">Jenis Barang</div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-tags fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-start-success border-start-3 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-success fw-semibold mb-1">Aktif</div>
                            <div class="h2 mb-0 fw-bold">{{ $jenisBarang->where('status', 1)->count() }}</div>
                            <div class="small text-muted">Jenis Aktif</div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-success bg-opacity-10 text-success">
                                <i class="fas fa-check-circle fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-start-warning border-start-3 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-warning fw-semibold mb-1">Nonaktif</div>
                            <div class="h2 mb-0 fw-bold">{{ $jenisBarang->where('status', 0)->count() }}</div>
                            <div class="small text-muted">Jenis Nonaktif</div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-times-circle fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-start-info border-start-3 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-info fw-semibold mb-1">Terakhir Update</div>
                            @php
                                $latest = $jenisBarang->sortByDesc('updated_at')->first();
                                $latestDate = $latest ? $latest->updated_at->format('d M Y') : '-';
                            @endphp
                            <div class="h5 mb-0 fw-bold">{{ $latestDate }}</div>
                            <div class="small text-muted">Update Terakhir</div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-info bg-opacity-10 text-info">
                                <i class="fas fa-history fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <div class="icon-circle bg-success bg-opacity-10 text-success me-3">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="flex-grow-1">
                    <strong>Sukses!</strong> {{ session('success') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <div class="icon-circle bg-danger bg-opacity-10 text-danger me-3">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="flex-grow-1">
                    <strong>Error!</strong> {{ session('error') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Main Card -->
    <div class="card shadow border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-list me-2"></i>
                Daftar Jenis Barang
            </h5>
            <div class="d-flex align-items-center">
                <div class="input-group input-group-sm me-3" style="width: 250px;">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Cari jenis barang...">
                </div>
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                    {{ $jenisBarang->count() }} Data
                </span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 60px;">No</th>
                            <th style="min-width: 100px;">Kode</th>
                            <th>Nama Jenis</th>
                            <th>Deskripsi</th>
                            <th class="text-center" style="width: 100px;">Status</th>
                            <th class="text-center" style="width: 120px;">Tanggal Dibuat</th>
                            <th class="text-center pe-4" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="jenisTableBody">
                        @forelse($jenisBarang as $jenis)
                        <tr>
                            <td class="ps-4 align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                                    {{ $jenis->kode_jenis }}
                                </span>
                            </td>
                            <td class="align-middle">
                                <div class="fw-semibold">{{ $jenis->nama_jenis }}</div>
                                <small class="text-muted">ID: {{ $jenis->id }}</small>
                            </td>
                            <td class="align-middle">
                                @if($jenis->deskripsi)
                                    <p class="mb-0 text-truncate" style="max-width: 250px;" 
                                       title="{{ $jenis->deskripsi }}">
                                        {{ $jenis->deskripsi }}
                                    </p>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                @if($jenis->status)
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2">
                                        <i class="fas fa-times-circle me-1"></i>Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <div class="small text-muted">
                                    {{ $jenis->created_at->format('d M Y') }}
                                </div>
                            </td>
                            <td class="text-center pe-4 align-middle">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('jenis-barang.edit', $jenis->id) }}" 
                                       class="btn btn-sm btn-warning" 
                                       data-bs-toggle="tooltip" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete('{{ $jenis->id }}', '{{ $jenis->nama_jenis }}')"
                                            data-bs-toggle="tooltip" 
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="icon-circle bg-light text-muted mx-auto mb-3">
                                    <i class="fas fa-tags fa-2x"></i>
                                </div>
                                <h4 class="text-muted mb-3">Belum ada jenis barang</h4>
                                <a href="{{ route('jenis-barang.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i>Tambah Jenis Pertama
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($jenisBarang->hasPages())
            <div class="card-footer bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Menampilkan {{ $jenisBarang->firstItem() ?? 0 }} - {{ $jenisBarang->lastItem() ?? 0 }} dari {{ $jenisBarang->total() }} data
                    </div>
                    <div>
                        {{ $jenisBarang->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus jenis barang <strong id="jenisNama"></strong>?</p>
                <p class="text-danger mb-0">
                    <i class="fas fa-info-circle me-1"></i>
                    Data yang sudah dihapus tidak dapat dikembalikan.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Batal
                </button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Hapus
                    </button>
                </form>
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

.table tbody tr {
    transition: background-color 0.15s ease-in-out;
}

.table tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02) !important;
}

.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.badge {
    font-weight: 500;
}

.btn-group .btn {
    border-radius: 0.375rem !important;
    margin: 0 1px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .table td, .table th {
        padding: 0.75rem 0.5rem;
    }
    
    .btn-group {
        flex-direction: column;
        gap: 4px;
    }
    
    .btn-group .btn {
        width: 100%;
        margin: 2px 0;
    }
    
    .input-group {
        width: 200px !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('jenisTableBody');
    
    if (searchInput && tableBody) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = tableBody.querySelectorAll('tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Table row click effect
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('click', function(e) {
            if (!e.target.closest('.btn') && !e.target.closest('a')) {
                this.classList.toggle('table-active');
            }
        });
    });
});

function confirmDelete(id, nama) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    document.getElementById('jenisNama').textContent = nama;
    document.getElementById('deleteForm').action = `/jenis-barang/${id}`;
    modal.show();
}

// Export to Excel
function exportToExcel() {
    window.location.href = "{{ route('jenis-barang.export') }}";
}

// Print functionality
function printTable() {
    window.print();
}

// Filter by status
function filterByStatus(status) {
    const rows = document.querySelectorAll('#jenisTableBody tr');
    rows.forEach(row => {
        if (status === 'all') {
            row.style.display = '';
        } else {
            const statusBadge = row.querySelector('.badge');
            if (statusBadge) {
                const isActive = statusBadge.classList.contains('bg-success');
                if ((status === 'active' && isActive) || (status === 'inactive' && !isActive)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        }
    });
}
</script>
@endsection