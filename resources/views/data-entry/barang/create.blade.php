@extends('layouts.app')

@section('title', 'Tambah Barang Masuk - Sistem Inventory')
@section('icon', 'fa-sign-in-alt')

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
            @foreach($bidang as $b)
                <option value="{{ $b->kode }}" 
                    {{ old('bidang_kode') == $b->kode ? 'selected' : '' }}>
                    {{ $b->nama }} ({{ $b->kode }})  <!-- PERUBAHAN DISINI: $b->nama -->
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
                                        Pakai Habis
                                    </option>
                                    <option value="aset_tetap" {{ old('jenis_barang') == 'aset_tetap' ? 'selected' : '' }}>
                                        Aset Tetap
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
                                <small class="text-muted">Format: [BIDANG]-[JENIS]-[NOMOR]</small>
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
    // Format Rupiah helper functions
    function formatRupiah(angka) {
        if (!angka) return '0';
        const number_string = angka.toString().replace(/[^,\d]/g, '');
        const split = number_string.split(',');
        const sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        const ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        
        if (ribuan) {
            const separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        return rupiah;
    }
    
    function unformatRupiah(rupiah) {
        if (!rupiah) return 0;
        return parseInt(rupiah.toString().replace(/\./g, ''), 10) || 0;
    }
    
    // Format input functions
    function formatHarga(input) {
        let value = input.value.replace(/[^\d]/g, '');
        const numericValue = parseInt(value) || 0;
        
        document.getElementById('harga_satuan_numeric').value = numericValue;
        input.value = formatRupiah(value);
        
        calculateTotal();
    }
    
    function formatJumlah(input) {
        let value = input.value.replace(/[^\d]/g, '');
        const numericValue = parseInt(value) || 0;
        
        document.getElementById('jumlah_numeric').value = numericValue;
        input.value = formatRupiah(value);
        
        calculateTotal();
    }
    
    // Calculate total
    function calculateTotal() {
        const jumlah = parseInt(document.getElementById('jumlah_numeric').value) || 0;
        const harga = parseInt(document.getElementById('harga_satuan_numeric').value) || 0;
        const total = jumlah * harga;
        
        // Format display
        document.getElementById('total_nilai_display').value = formatRupiah(total);
        document.getElementById('total_nilai').value = total;
        
        // Update text display
        document.getElementById('total_nilai_text').innerText = 
            `Rp ${formatRupiah(total)}`;
        
        document.getElementById('total_detail').innerText = 
            `Jumlah: ${formatRupiah(jumlah)} × Harga: Rp ${formatRupiah(harga)}`;
    }
    
    // Update kode barang otomatis
    function updateKodeBarang() {
        const bidang = document.getElementById('bidang_kode').value;
        const jenis = document.getElementById('jenis_barang').value;
        const kodeBarangInput = document.getElementById('kode_barang');
        
        if (bidang && jenis) {
            // Generate kode berdasarkan bidang dan jenis
            let jenisCode = '';
            if (jenis === 'pakai_habis') {
                jenisCode = 'PH';
            } else if (jenis === 'aset_tetap') {
                jenisCode = 'AT';
            }
            
            const timestamp = Date.now().toString().slice(-4);
            kodeBarangInput.value = `${bidang}-${jenisCode}-${timestamp}`;
        }
    }
    
    // Load barang berdasarkan bidang
    function loadBarangByBidang() {
        const bidangKode = document.getElementById('bidang_kode').value;
        const barangSelect = document.getElementById('barang_id');
        
        if (!bidangKode) return;
        
        // Clear existing options except first and last
        while (barangSelect.options.length > 2) {
            barangSelect.remove(1);
        }
        
        // Load via AJAX
        fetch(`/barang-by-bidang/${bidangKode}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(barang => {
                    const option = document.createElement('option');
                    option.value = barang.id;
                    option.setAttribute('data-kode', barang.kode_barang);
                    option.setAttribute('data-nama', barang.nama_barang);
                    option.setAttribute('data-satuan', barang.satuan);
                    option.setAttribute('data-harga', barang.harga_satuan);
                    option.setAttribute('data-kategori', barang.kategori_nama);
                    option.setAttribute('data-jenis', barang.jenis_barang);
                    option.textContent = `${barang.kode_barang} - ${barang.nama_barang}`;
                    barangSelect.insertBefore(option, barangSelect.lastChild);
                });
            })
            .catch(error => console.error('Error:', error));
    }
    
    // Load barang detail when selected
    function loadBarangDetail() {
        const barangSelect = document.getElementById('barang_id');
        const selectedOption = barangSelect.options[barangSelect.selectedIndex];
        
        if (selectedOption.value === 'new') {
            // Mode tambah barang baru
            enableNewBarangMode();
            updateKodeBarang();
            return;
        }
        
        if (selectedOption.value) {
            // Mode pilih barang yang ada
            const kode = selectedOption.getAttribute('data-kode');
            const nama = selectedOption.getAttribute('data-nama');
            const satuan = selectedOption.getAttribute('data-satuan');
            const harga = selectedOption.getAttribute('data-harga');
            const kategori = selectedOption.getAttribute('data-kategori');
            const jenis = selectedOption.getAttribute('data-jenis');
            
            // Isi form dengan data barang
            document.getElementById('kode_barang').value = kode;
            document.getElementById('nama_barang').value = nama;
            document.getElementById('satuan').value = satuan;
            document.getElementById('kategori_barang').value = kategori;
            document.getElementById('jenis_barang').value = jenis;
            
            // Format harga
            document.getElementById('harga_satuan_numeric').value = harga;
            document.getElementById('harga_satuan').value = formatRupiah(harga);
            
            // Disable beberapa field untuk editing
            document.getElementById('kode_barang').readOnly = true;
            document.getElementById('nama_barang').readOnly = false;
            document.getElementById('satuan').readOnly = false;
            document.getElementById('kategori_barang').readOnly = false;
            document.getElementById('jenis_barang').disabled = false;
        }
    }
    
    function enableNewBarangMode() {
        // Enable semua field untuk input baru
        document.getElementById('kode_barang').readOnly = false;
        document.getElementById('nama_barang').readOnly = false;
        document.getElementById('satuan').readOnly = false;
        document.getElementById('kategori_barang').readOnly = false;
        document.getElementById('jenis_barang').disabled = false;
        
        // Clear form
        document.getElementById('nama_barang').value = '';
        document.getElementById('satuan').value = '';
        document.getElementById('kategori_barang').value = '';
        document.getElementById('harga_satuan').value = '';
        document.getElementById('harga_satuan_numeric').value = '';
        document.getElementById('jumlah').value = '';
        document.getElementById('jumlah_numeric').value = '';
        
        // Reset kode barang jika bidang dan jenis sudah dipilih
        updateKodeBarang();
    }
    
    // Kategori functions
    function suggestKategori() {
        const suggestionDiv = document.getElementById('kategoriSuggestion');
        suggestionDiv.style.display = suggestionDiv.style.display === 'none' ? 'block' : 'none';
    }
    
    function setKategori(kategori) {
        document.getElementById('kategori_barang').value = kategori;
        document.getElementById('kategoriSuggestion').style.display = 'none';
        
        // Auto set jenis berdasarkan kategori
        const jenisSelect = document.getElementById('jenis_barang');
        const lowerKategori = kategori.toLowerCase();
        
        if (lowerKategori.includes('atk') || lowerKategori.includes('konsumsi') || lowerKategori.includes('logistik')) {
            jenisSelect.value = 'pakai_habis';
        } else if (lowerKategori.includes('elektronik') || lowerKategori.includes('furniture')) {
            jenisSelect.value = 'aset_tetap';
        }
        
        updateKodeBarang();
    }
    
    // Form validation
    document.getElementById('formBarangMasuk').addEventListener('submit', function(e) {
        const jumlah = parseInt(document.getElementById('jumlah_numeric').value) || 0;
        const harga = parseInt(document.getElementById('harga_satuan_numeric').value) || 0;
        const barangSelect = document.getElementById('barang_id');
        const selectedOption = barangSelect.options[barangSelect.selectedIndex];
        
        // Validasi jumlah
        if (jumlah <= 0) {
            e.preventDefault();
            alert('Jumlah harus lebih dari 0');
            document.getElementById('jumlah').focus();
            return false;
        }
        
        // Validasi harga
        if (harga < 0) {
            e.preventDefault();
            alert('Harga tidak boleh negatif');
            document.getElementById('harga_satuan').focus();
            return false;
        }
        
        // Jika pilih barang baru, validasi field tambahan
        if (selectedOption.value === 'new') {
            const kodeBarang = document.getElementById('kode_barang').value;
            const namaBarang = document.getElementById('nama_barang').value;
            const satuan = document.getElementById('satuan').value;
            const kategori = document.getElementById('kategori_barang').value;
            
            if (!kodeBarang || !namaBarang || !satuan || !kategori) {
                e.preventDefault();
                alert('Harap lengkapi semua field untuk barang baru');
                return false;
            }
            
            // Validasi format kode barang
            if (!/^[A-Z]{3}-[A-Z]{2}-\d{4}$/.test(kodeBarang)) {
                e.preventDefault();
                alert('Format kode barang tidak valid. Contoh: SKT-PH-0012');
                return false;
            }
        }
    });
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Load barang jika sudah dipilih sebelumnya
        const barangId = document.getElementById('barang_id');
        if (barangId.value) {
            loadBarangDetail();
        }
        
        // Generate kode barang jika bidang dan jenis sudah dipilih
        const bidang = document.getElementById('bidang_kode').value;
        const jenis = document.getElementById('jenis_barang').value;
        const kodeBarang = document.getElementById('kode_barang').value;
        
        if (bidang && jenis && !kodeBarang) {
            updateKodeBarang();
        }
        
        // Initial calculate
        calculateTotal();
    });
</script>
@endpush