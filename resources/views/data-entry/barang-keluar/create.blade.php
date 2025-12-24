@extends('layouts.app')

@section('title', 'Input Barang Keluar')
@section('icon', '')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-soft border-light-custom">
            
            <!-- Header -->
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex align-items-center">
                    <i class="fas fa-sign-out-alt fa-lg me-3"></i>
                    <h4 class="mb-0">Input Barang Keluar</h4>
                </div>
            </div>

            <div class="card-body p-4">
                <!-- Alert -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('barang-keluar.store') }}" method="POST" id="barangKeluarForm">
                    @csrf
                    
                    <!-- ========================= -->
                    <!-- INFORMASI TRANSAKSI -->
                    <!-- ========================= -->
                    <div class="mb-4">
                        <h5 class="text-primary mb-3 border-bottom pb-2">
                            <i class="fas fa-info-circle me-2"></i>Informasi Transaksi
                        </h5>
                        
                        <div class="row">
                            <!-- Tanggal Keluar -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tanggal Keluar <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-calendar text-muted"></i></span>
                                    <input type="date" name="tanggal_keluar"
                                           class="form-control @error('tanggal_keluar') is-invalid @enderror"
                                           value="{{ old('tanggal_keluar', date('Y-m-d')) }}" required>
                                </div>
                                @error('tanggal_keluar')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Bidang yang Mengeluarkan -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Bidang yang Mengeluarkan <span class="text-danger">*</span></label>
                                <select name="bidang_tujuan"
                                        class="form-select @error('bidang_tujuan') is-invalid @enderror"
                                        required>
                                    <option value="">-- Pilih Bidang --</option>
                                    @foreach ($bidang as $b)
                                        <option value="{{ $b }}"
                                            {{ old('bidang_tujuan') == $b ? 'selected' : '' }}>
                                            {{ $b }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bidang_tujuan')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- ========================= -->
                    <!-- PILIH BARANG -->
                    <!-- ========================= -->
                    <div class="mb-4">
                        <h5 class="text-primary mb-3 border-bottom pb-2">
                            <i class="fas fa-box-open me-2"></i>Pilih Barang
                        </h5>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih Barang <span class="text-danger">*</span></label>
                            <select name="barang_id" id="barang_id"
                                    class="form-select @error('barang_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach($barang as $item)
                                    <option value="{{ $item->id }}"
                                            data-stok="{{ $item->stok }}"
                                            data-satuan="{{ $item->satuan }}"
                                            data-jenis="{{ $item->jenis_barang }}"
                                            data-kategori="{{ $item->kategori->nama_kategori ?? '-' }}"
                                            data-harga="{{ $item->harga_satuan ?? 0 }}"
                                            {{ old('barang_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->kode_barang }} - {{ $item->nama_barang }}
                                        (Stok: {{ number_format($item->stok) }} {{ $item->satuan }})
                                    </option>
                                @endforeach
                            </select>
                            @error('barang_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- ========================= -->
                    <!-- INFORMASI BARANG -->
                    <!-- ========================= -->
                    <div class="mb-4">
                        <h5 class="text-primary mb-3 border-bottom pb-2">
                            <i class="fas fa-info-circle me-2"></i>Informasi Barang
                        </h5>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Jenis Barang</label>
                                <input type="text" id="jenis_barang" class="form-control bg-light" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Kategori</label>
                                <input type="text" id="kategori_barang" class="form-control bg-light" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Satuan</label>
                                <input type="text" id="satuan" class="form-control bg-light" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- ========================= -->
                    <!-- INFORMASI STOK & PENGELUARAN -->
                    <!-- ========================= -->
                    <div class="mb-4">
                        <h5 class="text-primary mb-3 border-bottom pb-2">
                            <i class="fas fa-calculator me-2"></i>Informasi Stok & Pengeluaran
                        </h5>

                        <div class="row">
                            <!-- Stok Barang (Otomatis) -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Stok Barang</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-warehouse text-muted"></i></span>
                                    <input type="text" id="stok_barang" class="form-control bg-light" readonly>
                                </div>
                                <small class="text-muted">Stok saat ini</small>
                            </div>

                            <!-- Barang Keluar (Input Manual) -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Jumlah Keluar <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-sign-out-alt text-muted"></i></span>
                                    <input type="number" min="1" step="1"
                                           id="jumlah" name="jumlah"
                                           class="form-control @error('jumlah') is-invalid @enderror"
                                           value="{{ old('jumlah') }}" 
                                           placeholder="0" required>
                                </div>
                                @error('jumlah')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Jumlah yang dikeluarkan</small>
                            </div>

                            <!-- Sisa Stok (Otomatis) -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Sisa Stok</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-calculator text-muted"></i></span>
                                    <input type="text" id="sisa_stok" class="form-control bg-light" readonly>
                                </div>
                                <small class="text-muted">Stok setelah pengeluaran</small>
                            </div>
                        </div>

                        <!-- Informasi Harga -->
                        <div class="row mt-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Harga Satuan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">Rp</span>
                                    <input type="text" id="harga_satuan" class="form-control bg-light text-end" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Total Nilai</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">Rp</span>
                                    <input type="text" id="total_nilai" class="form-control bg-light text-end" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ========================= -->
                    <!-- KETERANGAN -->
                    <!-- ========================= -->
                    <div class="mb-4">
                        <h5 class="text-primary mb-3 border-bottom pb-2">
                            <i class="fas fa-sticky-note me-2"></i>Keterangan
                        </h5>
                        <label class="form-label fw-semibold">Keterangan Pengeluaran</label>
                        <textarea name="keterangan" rows="3"
                                class="form-control @error('keterangan') is-invalid @enderror" 
                                placeholder="Contoh: Untuk keperluan rapat, pemakaian rutin, distribusi ke cabang, dll.">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ========================= -->
                    <!-- AKSI -->
                    <!-- ========================= -->
                    <div class="d-flex justify-content-between align-items-center border-top pt-4">
                        <span class="text-muted"><span class="text-danger">*</span> Wajib diisi</span>
                        
                        <div class="d-flex gap-2">
                            <a href="{{ route('barang-keluar.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>

                            <button type="submit" class="btn btn-primary px-4" id="submitBtn">
                                <i class="fas fa-save me-2"></i>Simpan Barang Keluar
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .border-light-custom {
        border: 1px solid #e3f2fd;
        border-radius: 0.75rem;
    }
    
    .card-header {
        border-radius: 0.75rem 0.75rem 0 0 !important;
    }
    
    .form-control:read-only {
        background-color: #f8f9fa;
        border-color: #e9ecef;
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        border-color: #e9ecef;
    }
    
    .text-primary {
        color: #1976d2 !important;
    }
    
    .border-bottom {
        border-bottom: 2px solid #e3f2fd !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const barangSelect = document.getElementById('barang_id');
        const jumlahInput = document.getElementById('jumlah');
        const form = document.getElementById('barangKeluarForm');
        const submitBtn = document.getElementById('submitBtn');

        // Initialize event listeners
        barangSelect.addEventListener('change', updateBarangInfo);
        jumlahInput.addEventListener('input', hitungStokDanHarga);
        
        // Initialize on page load
        if (barangSelect.value) {
            updateBarangInfo();
        }

        // Form validation
        form.addEventListener('submit', function(e) {
            const stokAwal = parseInt(barangSelect.options[barangSelect.selectedIndex]?.dataset.stok) || 0;
            const jumlahKeluar = parseInt(jumlahInput.value) || 0;
            
            if (jumlahKeluar > stokAwal) {
                e.preventDefault();
                showError('Jumlah keluar tidak boleh melebihi stok yang tersedia!');
                jumlahInput.focus();
                return;
            }
            
            if (jumlahKeluar <= 0) {
                e.preventDefault();
                showError('Jumlah keluar harus lebih dari 0!');
                jumlahInput.focus();
                return;
            }
            
            // Disable button to prevent double submission
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        });
    });

    function updateBarangInfo() {
        const opt = document.getElementById('barang_id').options[document.getElementById('barang_id').selectedIndex];
        
        if (!opt || !opt.value) {
            resetFields();
            return;
        }

        // Update informasi barang
        document.getElementById('jenis_barang').value = opt.dataset.jenis || '-';
        document.getElementById('kategori_barang').value = opt.dataset.kategori || '-';
        document.getElementById('satuan').value = opt.dataset.satuan || '-';
        document.getElementById('stok_barang').value = formatNumber(opt.dataset.stok || 0) + ' ' + (opt.dataset.satuan || '');
        
        // Update harga
        const hargaSatuan = parseInt(opt.dataset.harga) || 0;
        document.getElementById('harga_satuan').value = formatRupiah(hargaSatuan);
        
        // Set max value for jumlah input
        const jumlahInput = document.getElementById('jumlah');
        jumlahInput.max = opt.dataset.stok || 0;
        jumlahInput.value = '';
        
        // Reset perhitungan
        resetCalculations();
        
        // Focus ke input jumlah
        jumlahInput.focus();
    }

    function hitungStokDanHarga() {
        const opt = document.getElementById('barang_id').options[document.getElementById('barang_id').selectedIndex];
        const jumlahInput = document.getElementById('jumlah');
        
        if (!opt || !opt.value) {
            resetCalculations();
            return;
        }

        const stokAwal = parseInt(opt.dataset.stok) || 0;
        const jumlahKeluar = parseInt(jumlahInput.value) || 0;
        const hargaSatuan = parseInt(opt.dataset.harga) || 0;
        const satuan = opt.dataset.satuan || '';

        // Validasi stok
        if (jumlahKeluar > stokAwal) {
            jumlahInput.classList.add('is-invalid');
            showError('Jumlah keluar melebihi stok yang tersedia!');
            resetCalculations();
            return;
        } else if (jumlahKeluar <= 0 && jumlahInput.value !== '') {
            jumlahInput.classList.add('is-invalid');
            showError('Jumlah keluar harus lebih dari 0!');
            resetCalculations();
            return;
        } else {
            jumlahInput.classList.remove('is-invalid');
            hideError();
        }

        // Hitung sisa stok dan total nilai
        const sisaStok = stokAwal - jumlahKeluar;
        const totalNilai = jumlahKeluar * hargaSatuan;
        
        document.getElementById('sisa_stok').value = sisaStok >= 0 ? formatNumber(sisaStok) + ' ' + satuan : '0 ' + satuan;
        document.getElementById('total_nilai').value = formatRupiah(totalNilai);
    }

    function resetFields() {
        document.getElementById('jenis_barang').value = '';
        document.getElementById('kategori_barang').value = '';
        document.getElementById('satuan').value = '';
        document.getElementById('stok_barang').value = '';
        document.getElementById('harga_satuan').value = '';
        resetCalculations();
    }

    function resetCalculations() {
        document.getElementById('sisa_stok').value = '';
        document.getElementById('total_nilai').value = '';
    }

    function formatNumber(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }

    function formatRupiah(amount) {
        return 'Rp ' + formatNumber(amount);
    }

    function showError(message) {
        // Remove existing error alert
        hideError();
        
        // Create new error alert
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show d-flex align-items-center mt-3';
        alertDiv.innerHTML = `
            <i class="fas fa-exclamation-triangle me-2"></i>
            <div>${message}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        // Insert after the form
        document.querySelector('form').parentNode.insertBefore(alertDiv, document.querySelector('form'));
    }

    function hideError() {
        const existingAlert = document.querySelector('.alert-danger');
        if (existingAlert) {
            existingAlert.remove();
        }
    }
</script>
@endpush