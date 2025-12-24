@extends('layouts.app')

@section('title', 'Satuan Barang - Sistem Inventory')
@section('icon', '')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Header dengan Breadcrumb -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-balance-scale text-primary me-2"></i>
                Satuan Barang
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active">Satuan Barang</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('satuan.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus-circle me-2"></i>Tambah Satuan
            </a>
        </div>
    </div>
    
    <!-- Filter Jenis Satuan -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-filter me-2"></i>
                Filter Jenis Satuan
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <button class="btn btn-outline-primary w-100 py-3 active" onclick="filterByType('all')">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="icon-circle bg-primary bg-opacity-10 text-primary me-3">
                                <i class="fas fa-list"></i>
                            </div>
                            <div class="text-start">
                                <div class="fw-bold">Semua Satuan</div>
                                <small class="text-muted">{{ $totalSatuan ?? 0 }} Data</small>
                            </div>
                        </div>
                    </button>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <button class="btn btn-outline-success w-100 py-3" onclick="filterByType('pakai_habis')">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="icon-circle bg-success bg-opacity-10 text-success me-3">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <div class="text-start">
                                <div class="fw-bold">Habis Pakai</div>
                                <small class="text-muted">{{ $totalPakai ?? 0 }} Data</small>
                            </div>
                        </div>
                    </button>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-outline-warning w-100 py-3" onclick="filterByType('aset_tetap')">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="icon-circle bg-warning bg-opacity-10 text-warning me-3">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="text-start">
                                <div class="fw-bold">Aset Tetap</div>
                                <small class="text-muted">{{ $totalAset ?? 0 }} Data</small>
                            </div>
                        </div>
                    </button>
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
                <i class="fas fa-table me-2"></i>
                Daftar Satuan Barang
            </h5>
            <div class="d-flex align-items-center">
                <div class="input-group input-group-sm me-3" style="width: 250px;">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Cari satuan...">
                </div>
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2" id="totalBadge">
                    {{ $totalSatuan ?? 0 }} Data
                </span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 60px;">No</th>
                            <th>Kode Satuan</th>
                            <th>Nama Satuan</th>
                            <th>Jenis</th>
                            <th>Simbol</th>
                            <th class="text-center">Kategori</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 120px;">Dibuat</th>
                            <th class="text-center pe-4" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="satuanTableBody">
                        @php
                            $satuans = $satuans ?? collect([]);
                        @endphp
                        
                        @forelse($satuans as $satuan)
                        @php
                            $satuan = (object) $satuan; // Pastikan sebagai object
                        @endphp
                        <tr class="satuan-row" data-type="{{ $satuan->jenis_satuan ?? '' }}">
                            <td class="ps-4 align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                                    {{ $satuan->kode_satuan ?? 'SAT-' . str_pad($satuan->id ?? $loop->iteration, 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td class="align-middle">
                                <div class="fw-semibold">{{ $satuan->nama_satuan ?? 'N/A' }}</div>
                                @if(!empty($satuan->deskripsi))
                                    <small class="text-muted">{{ \Illuminate\Support\Str::limit($satuan->deskripsi, 50) }}</small>
                                @endif
                            </td>
                            <td class="align-middle">
                                @if(($satuan->jenis_satuan ?? '') == 'pakai_habis')
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                                        <i class="fas fa-box-open me-1"></i>Habis Pakai
                                    </span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2">
                                        <i class="fas fa-building me-1"></i>Aset Tetap
                                    </span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    @if(!empty($satuan->simbol))    
                                        <span class="badge bg-light text-dark border me-2">{{ $satuan->simbol }}</span>
                                    @endif
                                    <small>{{ $satuan->nama_satuan ?? '' }}</small>
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                @if(!empty($satuan->kategori))
                                    <span class="badge bg-info bg-opacity-10 text-info">{{ $satuan->kategori }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                @if($satuan->status ?? true)
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
                                    @if(isset($satuan->created_at) && $satuan->created_at)
                                        {{ \Carbon\Carbon::parse($satuan->created_at)->format('d M Y') }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </td>
                            <td class="text-center pe-4 align-middle">
                                <div class="btn-group" role="group">
                                    @if(isset($satuan->id))
                                    <a href="{{ route('satuan.edit', $satuan->id) }}" 
                                       class="btn btn-sm btn-warning" 
                                       data-bs-toggle="tooltip" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete('{{ $satuan->id }}', '{{ $satuan->nama_satuan ?? 'Satuan' }}')"
                                            data-bs-toggle="tooltip" 
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="icon-circle bg-light text-muted mx-auto mb-3">
                                    <i class="fas fa-balance-scale fa-2x"></i>
                                </div>
                                <h4 class="text-muted mb-3">Belum ada satuan barang</h4>
                                <a href="{{ route('satuan.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i>Tambah Satuan Pertama
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if(isset($satuans) && method_exists($satuans, 'hasPages') && $satuans->hasPages())
            <div class="card-footer bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Menampilkan {{ $satuans->firstItem() ?? 0 }} - {{ $satuans->lastItem() ?? 0 }} dari {{ $satuans->total() }} data
                    </div>
                    <div>
                        {{ $satuans->links() }}
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
                <p>Apakah Anda yakin ingin menghapus satuan <strong id="satuanNama"></strong>?</p>
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

/* Filter button active state */
.btn-outline-primary.active,
.btn-outline-success.active,
.btn-outline-warning.active {
    background-color: var(--bs-primary);
    color: white;
}

.btn-outline-success.active {
    background-color: var(--bs-success);
}

.btn-outline-warning.active {
    background-color: var(--bs-warning);
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
    
    .col-md-4 .btn {
        padding: 0.75rem 0.5rem;
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
    const tableBody = document.getElementById('satuanTableBody');
    
    if (searchInput && tableBody) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const visibleRows = tableBody.querySelectorAll('.satuan-row:not([style*="display: none"])');
            
            visibleRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            
            updateTotalCount();
        });
    }

    // Set active filter button on load
    const filterButtons = document.querySelectorAll('.card-body .btn');
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Initial active state for "all" button is already set in HTML
});

function filterByType(type) {
    const rows = document.querySelectorAll('.satuan-row');
    let visibleCount = 0;
    
    rows.forEach(row => {
        if (type === 'all' || row.getAttribute('data-type') === type) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Update badge count
    document.getElementById('totalBadge').textContent = visibleCount + ' Data';
    
    // Clear search if any
    document.getElementById('searchInput').value = '';
}

function confirmDelete(id, nama) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    document.getElementById('satuanNama').textContent = nama;
    document.getElementById('deleteForm').action = `/satuan/${id}`;
    modal.show();
}

function updateTotalCount() {
    const visibleRows = document.querySelectorAll('.satuan-row:not([style*="display: none"])');
    document.getElementById('totalBadge').textContent = visibleRows.length + ' Data';
}

// Export to Excel
function exportToExcel(type = 'all') {
    let url = "/satuan/export";
    if (type !== 'all') {
        url += `?type=${type}`;
    }
    window.location.href = url;
}

// Print functionality
function printTable() {
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        
    `);
    printWindow.document.close();
    printWindow.print();
}
</script>
@endsection