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

                    <!-- Kode Barang -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Barang <span class="text-danger">*</span></label>
                        <input type="text" name="kode_barang" id="kode_barang"
                               class="form-control @error('kode_barang') is-invalid @enderror"
                               placeholder="Contoh: SKT-PH-0012"
                               onblur="cariBarang()" required>
                        @error('kode_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Ketik kode barang → otomatis ambil data</small>
                    </div>

                    <!-- Info Barang -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" id="nama_barang" class="form-control" readonly>
                        </div>
                        <!-- Jenis & Bidang -->
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Jenis Barang</label>
        <input type="text" id="jenis_barang"
               class="form-control bg-light"
               readonly>
        <input type="hidden" name="jenis_barang" value="tetap">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Bidang</label>
        <input type="text" id="bidang"
               class="form-control bg-light"
               readonly>
        <input type="hidden" name="bidang_kode" id="bidang_kode">
    </div>
</div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Satuan</label>
                            <input type="text" id="satuan" class="form-control" readonly>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Kategori</label>
                            <input type="text" id="kategori" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Jumlah -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah_numeric" id="jumlah"
                               class="form-control @error('jumlah_numeric') is-invalid @enderror"
                               min="1" oninput="hitungTotal()" required>
                        @error('jumlah_numeric')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <!-- Harga -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Harga Satuan (Rp)</label>
                        <input type="number" name="harga_satuan_numeric" id="harga"
                               class="form-control" min="0" oninput="hitungTotal()">
                    </div>

                    <!-- Total -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Total Nilai</label>
                        <input type="text" id="total_display" class="form-control bg-light" readonly>
                        <input type="hidden" name="total_nilai" id="total">
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3"></textarea>
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
@endsection

<script>
function cariBarang() {
    const kode = document.getElementById('kode_barang').value.trim();
    if (!kode) return;

    fetch(`/api/barang/by-kode/${kode}`)
        .then(res => res.json())
        .then(res => {
            if (!res.success) throw res;

            document.getElementById('nama_barang').value = res.data.nama_barang;
            document.getElementById('satuan').value = res.data.satuan;
            document.getElementById('kategori').value = res.data.kategori;
            document.getElementById('harga').value = res.data.harga_satuan || 0;

            // ✅ BARU
            document.getElementById('bidang').value = res.data.bidang_nama;
            document.getElementById('bidang_kode').value = res.data.bidang_kode;

            hitungTotal();
        })
        .catch(() => {
            alert('Barang tidak ditemukan');

            document.getElementById('nama_barang').value = '';
            document.getElementById('satuan').value = '';
            document.getElementById('kategori').value = '';
            document.getElementById('harga').value = 0;
            document.getElementById('bidang').value = '';
            document.getElementById('bidang_kode').value = '';
        });
}
</script>
