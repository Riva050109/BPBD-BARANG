@extends('layouts.app')

@section('title', 'Daftar Bidang - Sistem Inventory')
@section('icon', '')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Header dengan Breadcrumb -->
    <!-- Main Card -->
    <div class="card shadow border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-list me-2"></i>
                Daftar Lengkap Bidang
            </h5>
            
                <a href="{{ route('barang.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Barang
                </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 60px;">No</th>
                            <th>Bidang</th>
                            <th class="text-center" style="width: 100px;">Kode</th>
                            <th class="text-center" style="width: 150px;">Jumlah Barang</th>
                            <th style="width: 200px;">Penanggung Jawab</th>
                            <th class="text-center pe-4" style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $bidangData = [
                                [
                                    'no' => 1,
                                    'kode' => 'SKT',
                                    'nama' => 'SEKRETARIAT',
                                    'deskripsi' => 'Bidang Administrasi dan Umum',
                                    'pj' => 'Sekretaris',
                                    'icon' => 'building',
                                    'color' => 'primary',
                                    'total' => $totalBarangSekretariat ?? 0
                                ],
                                [
                                    'no' => 2,
                                    'kode' => 'PKP',
                                    'nama' => 'BIDANG PENCEGAHAN DAN KESIAPSIAGAAN',
                                    'deskripsi' => 'Bidang Pencegahan dan Mitigasi',
                                    'pj' => 'Kepala Bidang Pencegahan',
                                    'icon' => 'shield-alt',
                                    'color' => 'success',
                                    'total' => $totalBarangPencegahan ?? 0
                                ],
                                [
                                    'no' => 3,
                                    'kode' => 'KDL',
                                    'nama' => 'BIDANG KEDARURATAN DAN LOGISTIK',
                                    'deskripsi' => 'Bidang Tanggap Darurat',
                                    'pj' => 'Kepala Bidang Kedaruratan',
                                    'icon' => 'ambulance',
                                    'color' => 'warning',
                                    'total' => $totalBarangKedaruratan ?? 0
                                ],
                                [
                                    'no' => 4,
                                    'kode' => 'RR',
                                    'nama' => 'BIDANG REHABILITASI DAN REKONSTRUKSI',
                                    'deskripsi' => 'Bidang Pemulihan Pasca Bencana',
                                    'pj' => 'Kepala Bidang Rehabilitasi',
                                    'icon' => 'home',
                                    'color' => 'info',
                                    'total' => $totalBarangRehabilitasi ?? 0
                                ]
                            ];
                        @endphp

                        @foreach($bidangData as $bidang)
                        <tr>
                            <td class="ps-4 align-middle">{{ $bidang['no'] }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-{{ $bidang['color'] }} bg-opacity-10 text-{{ $bidang['color'] }} me-3">
                                        <i class="fas fa-{{ $bidang['icon'] }}"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold text-{{ $bidang['color'] }}">{{ $bidang['nama'] }}</h6>
                                        <small class="text-muted">{{ $bidang['deskripsi'] }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge bg-{{ $bidang['color'] }} px-3 py-2 fs-6">{{ $bidang['kode'] }}</span>
                            </td>
                            <td class="text-center align-middle">
                                <div class="d-flex flex-column align-items-center">
                                    <span class="badge bg-{{ $bidang['color'] }} bg-opacity-10 text-{{ $bidang['color'] }} px-3 py-2 mb-1">
                                        <i class="fas fa-box me-2"></i>{{ $bidang['total'] }}
                                    </span>
                                    <small class="text-muted">Barang</small>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold">{{ $bidang['pj'] }}</span>
                                    <small class="text-muted">BPBD Kota/Kab</small>
                                </div>
                            </td>
                            <td class="text-center pe-4 align-middle">
                                <div class="btn-group" role="group">
                                   <a href="{{ route('barang.create', $bidang['kode']) }}" 
   class="btn btn-info btn-sm">
   Detail
</a>

                                    <a href="{{ route('barang.create') }}?bidang={{ $bidang['kode'] }}" class="btn btn-sm btn-{{ $bidang['color'] }}">
                                        <i class="fas fa-plus me-1"></i>Barang
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        {{-- Tambahkan di bagian atas setelah header --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Barang -->
<div class="modal fade" id="modalTambahBarang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Barang Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formTambahBarang" method="POST" action="{{ route('barang.create') }}">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Bidang -->
                        <div class="col-md-6">
                            <label class="form-label">Bidang <span class="text-danger">*</span></label>
                            <select class="form-select" name="bidang_kode" required>
                                <option value="">Pilih Bidang</option>
                                <option value="SKT">Sekretariat (SKT)</option>
                                <option value="PKP">Pencegahan (PKP)</option>
                                <option value="KDL">Kedaruratan (KDL)</option>
                                <option value="RR">Rehabilitasi (RR)</option>
                            </select>
                        </div>

                        <!-- Kode Barang -->
                        <div class="col-md-6">
                            <label class="form-label">Kode Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="kode_barang" required placeholder="INV-001">
                        </div>

                        <!-- Nama Barang -->
                        <div class="col-12">
                            <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_barang" required>
                        </div>

                        <!-- Jenis & Kategori -->
                        <div class="col-md-6">
                            <label class="form-label">Jenis Barang</label>
                            <select class="form-select" name="jenis_barang">
                                <option value="">Pilih Jenis</option>
                                <option value="ATK">ATK</option>
                                <option value="Elektronik">Elektronik</option>
                                <option value="Furniture">Furniture</option>
                                <option value="Logistik">Logistik</option>
                                <option value="Kendaraan">Kendaraan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <input type="text" class="form-control" name="kategori">
                        </div>

                        <!-- Satuan, Stok, Harga -->
                        <div class="col-md-4">
                            <label class="form-label">Satuan <span class="text-danger">*</span></label>
                            <select class="form-select" name="satuan" required>
                                <option value="">Pilih Satuan</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Unit">Unit</option>
                                <option value="Set">Set</option>
                                <option value="Pak">Pak</option>
                                <option value="Lusin">Lusin</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Stok Awal <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="stok" value="0" min="0" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Harga Satuan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="harga_satuan" value="0" min="0" required>
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="col-12">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" name="keterangan" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan Barang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail Barang (untuk AJAX) -->
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

<style>
/* CSS inline - Murni Bootstrap Utility Classes */
.icon-circle {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
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

.border-start-3 {
    border-left-width: 3px !important;
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
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate kode barang
    const bidangSelect = document.querySelector('select[name="bidang_kode"]');
    const kodeInput = document.querySelector('input[name="kode_barang"]');
    
    if (bidangSelect && kodeInput) {
        bidangSelect.addEventListener('change', function() {
            if (this.value && !kodeInput.value) {
                const timestamp = Date.now().toString().slice(-4);
                kodeInput.value = `${this.value}-${timestamp}`;
            }
        });
    }
    
    // Format currency input
    const hargaInput = document.querySelector('input[name="harga_satuan"]');
    if (hargaInput) {
        hargaInput.addEventListener('input', function(e) {
            let value = this.value.replace(/[^0-9]/g, '');
            if (value) {
                value = parseInt(value).toLocaleString('id-ID');
                this.value = value;
            }
        });
    }
    
    // Form validation
    const form = document.getElementById('formTambahBarang');
    if (form) {
        form.addEventListener('submit', function(e) {
            const stok = form.querySelector('input[name="stok"]').value;
            const harga = form.querySelector('input[name="harga_satuan"]').value;
            
            if (parseInt(stok) < 0) {
                e.preventDefault();
                alert('Stok tidak boleh negatif');
                return false;
            }
            
            if (parseInt(harga) < 0) {
                e.preventDefault();
                alert('Harga tidak boleh negatif');
                return false;
            }
        });
    }
    
    // Modal handlers
    const tambahBarangModal = document.getElementById('modalTambahBarang');
    if (tambahBarangModal) {
        tambahBarangModal.addEventListener('shown.bs.modal', function() {
            document.querySelector('input[name="nama_barang"]').focus();
        });
        
        tambahBarangModal.addEventListener('hidden.bs.modal', function() {
            form.reset();
        });
    }
});

// Fungsi untuk membuka modal tambah barang dengan bidang tertentu
function tambahBarang(kode) {
    const modal = new bootstrap.Modal(document.getElementById('modalTambahBarang'));
    document.querySelector('select[name="bidang_kode"]').value = kode;
    
    // Auto-generate kode
    const timestamp = Date.now().toString().slice(-4);
    document.querySelector('input[name="kode_barang"]').value = `${kode}-${timestamp}`;
    
    modal.show();
}

// Fungsi untuk melihat detail barang via AJAX
function lihatDetailBarang(id) {
    fetch(`/api/barang/${id}`)
        .then(response => response.json())
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
                            <p class="mb-0">${data.nama_barang}</p>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jenis</label>
                                <span class="badge bg-primary bg-opacity-10 text-primary">${data.jenis_barang}</span>
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
                                    ${data.stok.toLocaleString('id-ID')}
                                </p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Satuan</label>
                                <p class="mb-0">${data.satuan}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Harga Satuan</label>
                                <p class="mb-0 fw-bold">Rp ${data.harga_satuan.toLocaleString('id-ID')}</p>
                            </div>
                        </div>
                        ${data.keterangan ? `
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Keterangan</label>
                            <p class="mb-0">${data.keterangan}</p>
                        </div>
                        ` : ''}
                        <div class="alert alert-info">
                            <i class="fas fa-calculator me-2"></i>
                            <strong>Total Nilai:</strong> Rp ${(data.stok * data.harga_satuan).toLocaleString('id-ID')}
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

// Fungsi untuk hapus barang
function hapusBarang(id, nama) {
    if (confirm(`Apakah Anda yakin ingin menghapus barang "${nama}"?`)) {
        fetch(`/barang/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                location.reload();
            } else {
                alert('Gagal menghapus barang');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
}

// Fungsi untuk export data
function exportData(kode, format = 'excel') {
    let url = `/bidang/${kode}/export`;
    if (format === 'pdf') {
        url += '?format=pdf';
    }
    window.open(url, '_blank');
}

// Fungsi untuk print laporan
function printLaporan(kode) {
    const printWindow = window.open(`/bidang/${kode}/print`, '_blank');
    printWindow.focus();
}
</script>
@endsection