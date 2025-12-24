@extends('layouts.app')

@section('title', 'Laporan Stok Barang')

@section('icon', '')

@section('actions')
<div class="d-flex gap-2">
    <button class="btn btn-success btn-sm">
        <i class="fas fa-print me-1"></i> Cetak
    </button>
    <button class="btn btn-primary btn-sm">
        <i class="fas fa-download me-1"></i> Export
    </button>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Filter Section -->
        <div class="card shadow-soft border-light-custom mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0 text-gradient">Filter Laporan</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('laporan.stok') }}" method="GET" id="filterForm">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Jenis Barang</label>
                                <select class="form-select" name="jenis">
                                    <option value="">Semua Jenis</option>
                                    <option value="pakai_habis">Barang Pakai Habis</option>
                                    <option value="aset_tetap">Barang Aset Tetap</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select class="form-select" name="kategori">
                                    <option value="">Semua Kategori</option>
                                    <option value="makanan">Bahan Makanan</option>
                                    <option value="peralatan">Peralatan</option>
                                    <option value="pakaian">Pakaian</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Status Stok</label>
                                <select class="form-select" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="tersedia">Tersedia</option>
                                    <option value="menipis">Stok Menipis</option>
                                    <option value="habis">Stok Habis</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i> Terapkan Filter
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="resetFilter()">
                                <i class="fas fa-refresh me-1"></i> Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Laporan Section -->
        <div class="card shadow-soft border-light-custom">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-gradient">Laporan Stok Barang</h5>
                <span class="badge bg-primary">Update: {{ $tanggal }}</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jenis</th>
                                <th>Kategori</th>
                                <th>Stok Awal</th>
                                <th>Masuk</th>
                                <th>Keluar</th>
                                <th>Stok Akhir</th>
                                <th>Satuan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data Contoh -->
                            <tr>
                                <td>1</td>
                                <td>BRG-001</td>
                                <td>Beras</td>
                                <td><span class="badge badge-pakai-habis">Pakai Habis</span></td>
                                <td>Bahan Makanan</td>
                                <td>1,000</td>
                                <td>350</td>
                                <td>80</td>
                                <td>1,270</td>
                                <td>Kg</td>
                                <td><span class="badge bg-success">Tersedia</span></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>BRG-002</td>
                                <td>Tenda Darurat</td>
                                <td><span class="badge badge-aset-tetap">Aset Tetap</span></td>
                                <td>Peralatan</td>
                                <td>50</td>
                                <td>10</td>
                                <td>5</td>
                                <td>55</td>
                                <td>Unit</td>
                                <td><span class="badge bg-success">Tersedia</span></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>BRG-003</td>
                                <td>Selimut</td>
                                <td><span class="badge badge-pakai-habis">Pakai Habis</span></td>
                                <td>Pakaian</td>
                                <td>500</td>
                                <td>100</td>
                                <td>75</td>
                                <td>525</td>
                                <td>Buah</td>
                                <td><span class="badge bg-success">Tersedia</span></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>BRG-004</td>
                                <td>Generator Listrik</td>
                                <td><span class="badge badge-aset-tetap">Aset Tetap</span></td>
                                <td>Peralatan</td>
                                <td>10</td>
                                <td>0</td>
                                <td>0</td>
                                <td>10</td>
                                <td>Unit</td>
                                <td><span class="badge bg-success">Tersedia</span></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>BRG-005</td>
                                <td>Air Mineral</td>
                                <td><span class="badge badge-pakai-habis">Pakai Habis</span></td>
                                <td>Bahan Makanan</td>
                                <td>200</td>
                                <td>0</td>
                                <td>150</td>
                                <td>50</td>
                                <td>Karton</td>
                                <td><span class="badge bg-warning">Menipis</span></td>
                            </tr>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="5" class="text-end">Total:</th>
                                <th>1,760</th>
                                <th>460</th>
                                <th>310</th>
                                <th>1,910</th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Summary Cards -->
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title">Total Barang</h6>
                                        <h3>5</h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-boxes fa-2x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title">Stok Tersedia</h6>
                                        <h3>4</h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-check-circle fa-2x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title">Stok Menipis</h6>
                                        <h3>1</h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title">Total Stok</h6>
                                        <h3>1,910</h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-cube fa-2x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Reset filter
    function resetFilter() {
        document.getElementById('filterForm').reset();
        window.location.href = "{{ route('laporan.stok') }}";
    }
</script>
@endpush