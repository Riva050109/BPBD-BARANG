@extends('layouts.app')

@section('title', 'BA Penyerahan Barang')
@section('icon', '')

@section('content')
<!-- Filter Section -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-light">
        <h5 class="card-title mb-0 text-dark">
            <i class="fas fa-filter me-2"></i>Filter Laporan
        </h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('laporan.ba-penyerahan') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Tanggal Awal</label>
                <input type="date" name="tanggal_awal" class="form-control" value="{{ $tanggal_awal }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" class="form-control" value="{{ $tanggal_akhir }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Bidang</label>
                <select name="bidang" class="form-select">
                    @foreach($bidangOptions as $value => $label)
                        <option value="{{ $value }}" {{ $bidang == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search me-1"></i>Filter
                </button>
                <a href="{{ route('laporan.ba-penyerahan') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- BA Penyerahan Reports -->
@if($baData->count() > 0)
    @foreach($baData as $tanggal => $items)
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-file-contract me-2"></i>
                Berita Acara Penyerahan Barang
            </h5>
        </div>
        <div class="card-body">
            <!-- Header BA -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Nomor BA</th>
                            <td>BA/BPBD/{{ date('Y/m/d', strtotime($tanggal)) }}/{{ $loop->iteration }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Penyerahan</th>
                            <td>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td>Gudang BPBD</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Yang Menyerahkan</th>
                            <td>Penanggung Jawab Gudang BPBD</td>
                        </tr>
                        <tr>
                            <th>Jabatan</th>
                            <td>Admin Gudang</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Daftar Barang -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Spesifikasi</th>
                            <th>Satuan</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Penerima</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->barang->kode_barang }}</td>
                            <td>{{ $item->barang->nama_barang }}</td>
                            <td>{{ $item->barang->kategori->nama_kategori ?? '-' }}</td>
                            <td class="text-center">{{ $item->barang->satuan }}</td>
                            <td class="text-center">{{ $item->jumlah }}</td>
                            <td>{{ $item->keperluan }}</td>
                            <td>{{ $item->penerima }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tanda Tangan -->
            <div class="row mt-5">
                <div class="col-md-6 text-center">
                    <p class="mb-4">Yang Menyerahkan,</p>
                    <br><br><br>
                    <p class="fw-bold border-top pt-2">___________________</p>
                    <p>Penanggung Jawab Gudang</p>
                </div>
                <div class="col-md-6 text-center">
                    <p class="mb-4">Yang Menerima,</p>
                    <br><br><br>
                    <p class="fw-bold border-top pt-2">___________________</p>
                    <p>Penerima Barang</p>
                </div>
            </div>

            <!-- Tombol Print -->
            <div class="text-end mt-4">
                <button onclick="window.print()" class="btn btn-success">
                    <i class="fas fa-print me-1"></i>Cetak BA
                </button>
            </div>
        </div>
    </div>
    @endforeach
@else
    <div class="card shadow-sm">
        <div class="card-body text-center py-5">
            <i class="fas fa-file-invoice fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">Tidak ada data penyerahan barang</h5>
            <p class="text-muted">Tidak ada barang keluar pada periode yang dipilih</p>
        </div>
    </div>
@endif

<style>
@media print {
    .card-header {
        background: #f8f9fa !important;
        color: #000 !important;
    }
    .btn, .card:first-child {
        display: none !important;
    }
    .card {
        border: 1px solid #000 !important;
        box-shadow: none !important;
    }
    table {
        border: 1px solid #000 !important;
    }
    th {
        background: #f8f9fa !important;
        color: #000 !important;
    }
}
</style>
@endsection