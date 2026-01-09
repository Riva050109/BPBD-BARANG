@extends('layouts.app')

@section('title', 'Tambah Barang Masuk - Sistem Inventory')
@section('icon', '')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-soft border-light-custom">
            
            <!-- Header -->
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex align-items-center">
                    <i class="fas fa-plus-circle fa-lg me-3"></i>
                    <h4 class="mb-0">Tambah Barang Masuk</h4>
                </div>
            </div>
            
            <div class="card-body p-4"> 
                <form action="{{ route('barang-masuk.store') }}" method="POST" id="formBarangMasuk">
                    @csrf
                    
                    <!-- INFORMASI TRANSAKSI -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-info-circle me-2"></i>Informasi Transaksi
                            </h5>
                        </div>
                         
                        <!-- Tanggal Masuk -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tanggal Masuk <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-calendar text-muted"></i></span>
                                    <input type="date" name="tanggal_masuk"
                                           class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                           value="{{ old('tanggal_masuk', date('Y-m-d')) }}" 
                                           required>
                                </div>
                                @error('tanggal_masuk')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                       <!-- Bidang -->
<div class="col-md-4">
    <div class="mb-3">
        <label class="form-label fw-semibold">Bidang <span class="text-danger">*</span></label>
        <select name="bidang_kode" id="bidang_kode"
                class="form-select @error('bidang_kode') is-invalid @enderror"
                required 
                onchange="updateKodeBarang(); loadBarangByBidang();">
           <option value="">-- Pilih Bidang --</option>
@foreach($bidangs as $b)
    <option value="{{ $b->kode }}"
        {{ old('bidang_kode') == $b->kode ? 'selected' : '' }}>
        {{ $b->nama }} ({{ $b->kode }})
    </option>
@endforeach

        </select>
        @error('bidang_kode')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>
                
                        <!-- Jenis Barang -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Jenis Barang <span class="text-danger">*</span></label>
                                <select name="jenis_barang" id="jenis_barang"
                                        class="form-select @error('jenis_barang') is-invalid @enderror"
                                        required 
                                        onchange="updateKodeBarang()">
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="pakai_habis" {{ old('jenis_barang') == 'pakai_habis' ? 'selected' : '' }}>
                                        pakai habis
                                    </option>
                                    <option value="aset_tetap" {{ old('jenis_barang') == 'aset_tetap' ? 'selected' : '' }}>
                                        aset tetap
                                    </option>
                                </select>
                                @error('jenis_barang')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Kode Barang -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kode Barang <span class="text-danger">*</span></label>
                                <input type="text" name="kode_barang" id="kode_barang"
                                       class="form-control shadow-sm @error('kode_barang') is-invalid @enderror"
                                       value="{{ old('kode_barang') }}" 
                                       placeholder="Kode akan terisi otomatis" 
                                       required>
                                @error('kode_barang')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                    
                            </div>
                        </div>
                    </div>
                    
                    <!-- PILIH BARANG -->
                    <div class="row mb-4">
                        <!-- Nama Barang -->
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" name="nama_barang" id="nama_barang"
                                       class="form-control shadow-sm @error('nama_barang') is-invalid @enderror"
                                       value="{{ old('nama_barang') }}" 
                                       placeholder="Nama barang" 
                                       required>
                                @error('nama_barang')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Satuan -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Satuan <span class="text-danger">*</span></label>
                                <input type="text" name="satuan" id="satuan"
                                       class="form-control shadow-sm @error('satuan') is-invalid @enderror"
                                       value="{{ old('satuan') }}" 
                                       placeholder="Contoh: pcs, unit" 
                                       required>
                                @error('satuan')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Kategori Barang -->
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kategori Barang <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="kategori_barang" id="kategori_barang"
                                           class="form-control shadow-sm @error('kategori_barang') is-invalid @enderror"
                                           value="{{ old('kategori_barang') }}" 
                                           placeholder="Contoh: ATK, Elektronik" 
                                           required>
                                   
                                </div>
                                @error('kategori_barang')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        </div>
                    </div>
                    
                    <!-- INFORMASI JUMLAH & HARGA -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-balance-scale me-2"></i>Informasi Jumlah & Harga
                            </h5>
                        </div>
                        
                        <!-- Jumlah -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Jumlah <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-boxes text-muted"></i></span>
                                    <input type="text" id="jumlah" name="jumlah"
                                           class="form-control @error('jumlah') is-invalid @enderror"
                                           value="{{ old('jumlah') }}" 
                                           placeholder="0"
                                           required 
                                           oninput="formatJumlah(this); calculateTotal();">
                                    <span class="input-group-text">Unit</span>
                                </div>
                                <input type="hidden" id="jumlah_numeric" name="jumlah_numeric">
                                @error('jumlah')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Harga Satuan -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Harga Satuan (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">Rp</span>
                                    <input type="text" id="harga_satuan" name="harga_satuan"
                                           class="form-control @error('harga_satuan') is-invalid @enderror"
                                           value="{{ old('harga_satuan') }}" 
                                           placeholder="0"
                                           required 
                                           oninput="formatHarga(this); calculateTotal();">
                                </div>
                                <input type="hidden" id="harga_satuan_numeric" name="harga_satuan_numeric">
                                @error('harga_satuan')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Total Nilai -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Total Nilai (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">Rp</span>
                                    <input type="text" id="total_nilai_display" 
                                           class="form-control bg-light" 
                                           value="0" 
                                           readonly>
                                </div>
                                <input type="hidden" id="total_nilai" name="total_nilai">
                            </div>
                        </div>
                    </div>

                    <!-- TOTAL NILAI CARD -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-light border-0">
                                <div class="card-body text-center py-3">
                                    <h6 class="text-muted mb-2">Total Nilai Barang Masuk</h6>
                                    <h3 class="text-success mb-0" id="total_nilai_text">Rp 0</h3>
                                    <small class="text-muted" id="total_detail">Jumlah: 0 × Harga: Rp 0</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KETERANGAN -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Keterangan</label>
                        <textarea name="keterangan" 
                                  class="form-control" 
                                  rows="3"
                                  placeholder="Contoh: Pembelian rutin, bantuan, donasi, dll.">{{ old('keterangan') }}</textarea>
                    </div>

                    <!-- AKSI -->
                    <div class="d-flex justify-content-between align-items-center border-top pt-4">
                        <span class="text-muted"><span class="text-danger">*</span> Wajib diisi</span>

                        <div class="d-flex gap-2">
                            <a href="{{ route('barang-masuk.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>

                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>Simpan Barang Masuk
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
        border: 1px solid #e0e0e0;
    }
    
    .shadow-soft {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .badge {
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .badge:hover {
        background-color: #0d6efd !important;
        color: white !important;
        transform: translateY(-1px);
    }
    
    #kategoriSuggestion {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>
@endpush

@push('scripts')
<script>
    function formatRupiah(angka) {
        if (!angka) return '0';
        return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function formatHarga(input) {
        let value = input.value.replace(/[^\d]/g, '');
        document.getElementById('harga_satuan_numeric').value = value || 0;
        input.value = formatRupiah(value);
        calculateTotal();
    }

    function formatJumlah(input) {
        let value = input.value.replace(/[^\d]/g, '');
        document.getElementById('jumlah_numeric').value = value || 0;
        input.value = formatRupiah(value);
        calculateTotal();
    }

    function calculateTotal() {
        const jumlah = parseInt(document.getElementById('jumlah_numeric').value) || 0;
        const harga = parseInt(document.getElementById('harga_satuan_numeric').value) || 0;
        const total = jumlah * harga;

        document.getElementById('total_nilai').value = total;
        document.getElementById('total_nilai_display').value = formatRupiah(total);
        document.getElementById('total_nilai_text').innerText = `Rp ${formatRupiah(total)}`;
        document.getElementById('total_detail').innerText =
            `Jumlah: ${formatRupiah(jumlah)} × Harga: Rp ${formatRupiah(harga)}`;
    }

    function updateKodeBarang() {
        const bidang = document.getElementById('bidang_kode').value;
        const jenis = document.getElementById('jenis_barang').value;
        const kodeInput = document.getElementById('kode_barang');

        if (bidang && jenis) {
            const jenisKode = jenis === 'pakai_habis' ? 'PH' : 'AT';
            const random = Math.floor(1000 + Math.random() * 9000);
            kodeInput.value = `${bidang}-${jenisKode}-${random}`;
        }
    }

    document.getElementById('formBarangMasuk').addEventListener('submit', function (e) {
        const jumlah = parseInt(document.getElementById('jumlah_numeric').value) || 0;
        const harga = parseInt(document.getElementById('harga_satuan_numeric').value) || 0;

        if (jumlah <= 0) {
            e.preventDefault();
            alert('Jumlah harus lebih dari 0');
            return false;
        }

        if (harga < 0) {
            e.preventDefault();
            alert('Harga tidak valid');
            return false;
        }
    });
</script>
@endpush
