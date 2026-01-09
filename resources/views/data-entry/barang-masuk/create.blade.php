@extends('layouts.app')

@section('title', 'Tambah Barang Masuk')
@section('icon', '')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Barang Masuk
                </h5>
            </div>

            <div class="card-body">
                <form action="{{ route('barang-masuk.store') }}" method="POST">
                    @csrf

                    <!-- Tanggal -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal Masuk <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_masuk"
                               class="form-control @error('tanggal_masuk') is-invalid @enderror"
                               value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
                        @error('tanggal_masuk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
    <label class="form-label">Nama Barang *</label>
    <select name="barang_id" class="form-control" required>
        <option value="">-- Pilih Barang --</option>
        @foreach ($barang as $b)
            <option value="{{ $b->id }}">
                {{ $b->nama_barang }}
            </option>
        @endforeach
    </select>
</div>


                    <!-- Info Barang -->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Jenis Barang <span class="text-danger">*</span></label>
                            <select name="jenis_barang" class="form-control @error('jenis_barang') is-invalid @enderror" required>
                                <option value="">Pilih Jenis</option>
                                <option value="tetap" {{ old('jenis_barang') == 'tetap' ? 'selected' : '' }}>Tetap</option>
                                <option value="habis_pakai" {{ old('jenis_barang') == 'habis_pakai' ? 'selected' : '' }}>Habis Pakai</option>
                            </select>
                            @error('jenis_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Bidang</label>
                            <select name="bidang_kode" class="form-control @error('bidang_kode') is-invalid @enderror">
                                <option value="">Pilih Bidang</option>
                                @php
                                    // Ambil data bidang langsung di view
                                    $bidangs = \App\Models\Bidang::orderBy('nama')->get();
                                @endphp
                                @foreach($bidangs as $bidang)
                                    <option value="{{ $bidang->kode }}" {{ old('bidang_kode') == $bidang->kode ? 'selected' : '' }}>
                                        {{ $bidang->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bidang_kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Kategori</label>
                            <input type="text" name="kategori"
                                   class="form-control @error('kategori') is-invalid @enderror"
                                   value="{{ old('kategori') }}"
                                   placeholder="Contoh: Elektronik, Kantor, dll">
                            @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Kode Barang -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Barang</label>
                        <input type="text" name="kode_barang"
                               class="form-control @error('kode_barang') is-invalid @enderror"
                               value="{{ old('kode_barang') }}"
                               placeholder="Contoh: SKT-PH-0012">
                        @error('kode_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <!-- Jumlah dan Satuan -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_numeric" id="jumlah"
                                   class="form-control @error('jumlah_numeric') is-invalid @enderror"
                                   value="{{ old('jumlah_numeric') }}"
                                   min="1" oninput="hitungTotal()" required>
                            @error('jumlah_numeric')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Satuan <span class="text-danger">*</span></label>
                            <select name="satuan" class="form-control @error('satuan') is-invalid @enderror" required>
                                <option value="">Pilih Satuan</option>
                                <option value="Pcs" {{ old('satuan') == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                                <option value="Unit" {{ old('satuan') == 'Unit' ? 'selected' : '' }}>Unit</option>
                                <option value="Set" {{ old('satuan') == 'Set' ? 'selected' : '' }}>Set</option>
                                <option value="Pak" {{ old('satuan') == 'Pak' ? 'selected' : '' }}>Pak</option>
                                <option value="Lembar" {{ old('satuan') == 'Lembar' ? 'selected' : '' }}>Lembar</option>
                                <option value="Botol" {{ old('satuan') == 'Botol' ? 'selected' : '' }}>Botol</option>
                                <option value="Dus" {{ old('satuan') == 'Dus' ? 'selected' : '' }}>Dus</option>
                                <option value="Rim" {{ old('satuan') == 'Rim' ? 'selected' : '' }}>Rim</option>
                                <option value="Roll" {{ old('satuan') == 'Roll' ? 'selected' : '' }}>Roll</option>
                                <option value="Meter" {{ old('satuan') == 'Meter' ? 'selected' : '' }}>Meter</option>
                            </select>
                            @error('satuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Harga dan Total -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Harga Satuan (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga_satuan_numeric" id="harga"
                                       class="form-control @error('harga_satuan_numeric') is-invalid @enderror"
                                       value="{{ old('harga_satuan_numeric') }}"
                                       min="0" oninput="hitungTotal()" required>
                                @error('harga_satuan_numeric')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <small class="text-muted">Harga per satuan barang</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Total Nilai (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" id="total_display" class="form-control bg-light" readonly>
                            </div>
                            <input type="hidden" name="total_nilai" id="total">
                            <small class="text-muted">Jumlah × Harga Satuan</small>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" 
                                  rows="3" placeholder="Tambahkan catatan jika diperlukan">{{ old('keterangan') }}</textarea>
                        @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <!-- Aksi -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('barang-masuk.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function hitungTotal() {
    const jumlah = parseFloat(document.getElementById('jumlah').value) || 0;
    const harga = parseFloat(document.getElementById('harga').value) || 0;
    const total = jumlah * harga;
    
    document.getElementById('total').value = total;
    document.getElementById('total_display').value = formatRupiah(total);
}

function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(angka);
}

// Hitung total saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    hitungTotal();
});
</script>
@endsection