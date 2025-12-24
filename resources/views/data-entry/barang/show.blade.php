@extends('layouts.app')

@section('title', 'Detail Bidang - Sistem Inventory')
@section('icon', '')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Header dengan Breadcrumb -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-sitemap text-primary me-2"></i>
                Detail Bidang: {{ $bidangNama }}
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('bidang.index') }}" class="text-decoration-none">Bidang</a></li>
                    <li class="breadcrumb-item active">{{ $bidangNama }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('bidang.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Stats Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-start-primary border-start-3 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle bg-primary bg-opacity-10 text-primary me-3">
                                    <i class="fas fa-sitemap fa-2x"></i>
                                </div>
                                <div>
                                    <h2 class="mb-0 fw-bold">{{ $bidangNama }}</h2>
                                    <div class="badge bg-primary px-3 py-2 fs-6 mt-2">Kode: {{ $kode }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="mb-2">
                                <span class="h1 fw-bold text-primary">{{ $totalBarang }}</span>
                            </div>
                            <div class="text-muted">Total Barang</div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="mb-2">
                                <span class="h1 fw-bold text-success">Rp {{ number_format($totalNilai, 0, ',', '.') }}</span>
                            </div>
                            <div class="text-muted">Total Nilai Inventaris</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Barang -->
    <div class="card shadow border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-boxes me-2"></i>
                Daftar Barang {{ $bidangNama }}
            </h5>
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                {{ $totalBarang }} Barang
            </span>
        </div>
        <div class="card-body p-0">
            @if($barang->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 60px;">No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th class="text-center">Jenis</th>
                            <th class="text-center">Stok</th>
                            <th class="text-center">Satuan</th>
                            <th class="text-end pe-4" style="width: 150px;">Harga Satuan</th>
                            <th class="text-end pe-4" style="width: 150px;">Total Nilai</th>
                            <th class="text-center pe-4" style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barang as $item)
                        <tr>
                            <td class="ps-4 align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">
                                <span class="badge bg-secondary">{{ $item->kode_barang }}</span>
                            </td>
                            <td class="align-middle fw-semibold">{{ $item->nama_barang }}</td>
                            <td class="text-center align-middle">
                                <span class="badge bg-info bg-opacity-10 text-info">{{ $item->jenis_barang }}</span>
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge {{ $item->stok < 10 ? 'bg-danger' : 'bg-success' }} px-3 py-2">
                                    {{ $item->stok }}
                                </span>
                            </td>
                            <td class="text-center align-middle">{{ $item->satuan }}</td>
                            <td class="text-end align-middle pe-4">
                                Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                            </td>
                            <td class="text-end align-middle pe-4 fw-bold">
                                Rp {{ number_format($item->stok * $item->harga_satuan, 0, ',', '.') }}
                            </td>
                            <td class="text-center pe-4 align-middle">
                                <button type="button" class="btn btn-sm btn-info" onclick="lihatDetailBarang({{ $item->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="7" class="text-end fw-bold pe-4">TOTAL KESELURUHAN:</td>
                            <td class="text-end fw-bold text-success pe-4">
                                Rp {{ number_format($totalNilai, 0, ',', '.') }}
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <div class="icon-circle bg-light text-muted mx-auto mb-3">
                    <i class="fas fa-box fa-2x"></i>
                </div>
                <h4 class="text-muted mb-3">Belum ada barang di bidang ini</h4>
                                <a href="{{ route('barang.create') }}?bidang={{ $kode }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Barang Pertama
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Detail Barang -->
<div class="modal fade" id="modalDetailBarang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle me-2"></i>
                    Detail Barang
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailBarangContent">
                <!-- Content akan diisi via AJAX -->
            </div>
        </div>
    </div>
</div>

<script>
function lihatDetailBarang(id) {
    fetch(`/barang/${id}/detail`)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            const content = document.getElementById('detailBarangContent');
            content.innerHTML = `
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <div class="icon-circle bg-primary bg-opacity-10 text-primary mx-auto mb-3">
                                    <i class="fas fa-box fa-2x"></i>
                                </div>
                                <h4 class="mb-0">${data.kode_barang}</h4>
                                <small class="text-muted">Kode Barang</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Barang</label>
                            <p class="mb-0 fs-5">${data.nama_barang}</p>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jenis Barang</label>
                                <p class="mb-0"><span class="badge bg-info">${data.jenis_barang}</span></p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kategori</label>
                                <p class="mb-0">${data.kategori || '-'}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Stok</label>
                                <p class="mb-0 fs-4 fw-bold ${data.stok < 10 ? 'text-danger' : 'text-success'}">
                                    ${data.stok}
                                </p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Satuan</label>
                                <p class="mb-0">${data.satuan}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Harga Satuan</label>
                                <p class="mb-0 fw-bold">Rp ${new Intl.NumberFormat('id-ID').format(data.harga_satuan)}</p>
                            </div>
                        </div>
                        ${data.keterangan ? `
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Keterangan</label>
                            <p class="mb-0">${data.keterangan}</p>
                        </div>
                        ` : ''}
                        <div class="alert alert-success">
                            <i class="fas fa-calculator me-2"></i>
                            <strong>Total Nilai:</strong> Rp ${new Intl.NumberFormat('id-ID').format(data.stok * data.harga_satuan)}
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-history me-2"></i>
                            <strong>Tanggal Input:</strong> ${new Date(data.created_at).toLocaleDateString('id-ID', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            })}
                        </div>
                    </div>
                </div>
            `;
            
            const modal = new bootstrap.Modal(document.getElementById('modalDetailBarang'));
            modal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal memuat detail barang');
        });
}
</script>
@endsection