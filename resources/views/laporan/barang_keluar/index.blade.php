@extends('layouts.app')

@section('title', 'Laporan Keluar Barang')
@section('icon', 'fas fa-file-alt')

@section('content')
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-soft border-light-custom">

            <!-- Header -->
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex align-items-center">
                    <i class="fas fa-file-alt fa-lg me-3"></i>
                    <h4 class="mb-0">Laporan Keluar Barang</h4>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body p-4">

                <!-- Form Filter -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Laporan</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('laporan.keluar.generate') }}" method="GET" id="formFilter">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Tanggal Mulai</label>
                                        <input type="date" name="start_date" class="form-control" 
                                               value="{{ request('start_date') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Tanggal Akhir</label>
                                        <input type="date" name="end_date" class="form-control" 
                                               value="{{ request('end_date') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Bidang Tujuan</label>
                                        <select name="bidang_tujuan" class="form-select">
                                            <option value="">Semua Bidang</option>
                                            @foreach($bidang as $b)
                                                <option value="{{ $b }}" {{ request('bidang_tujuan') == $b ? 'selected' : '' }}>
                                                    {{ $b }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">&nbsp;</label>
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-search me-2"></i>Filter
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Laporan -->
                <div class="card">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="fas fa-list me-2"></i>Data Laporan</h6>
                        <div>
                            <button class="btn btn-sm btn-success" onclick="printLaporan()">
                                <i class="fas fa-print me-2"></i>Print
                            </button>
                            <button class="btn btn-sm btn-warning" onclick="exportPDF()">
                                <i class="fas fa-file-pdf me-2"></i>PDF
                            </button>
                        </div>
                    </div>
                    <div class="card-body" id="laporanContent">

                        <!-- Kop Surat -->
                        <div class="text-center mb-4">
                            <h4 class="mb-1">BADAN PENANGGULANGAN BENCANA DAERAH</h4>
                            <h5 class="mb-1">PROVINSI/KABUPATEN [NAMA DAERAH]</h5>
                            <p class="mb-0">Alamat: Jl. Contoh No. 123, Telp: (021) 1234567</p>
                            <hr class="my-3">
                            <h4 class="text-primary">LAPORAN BARANG KELUR</h4>
                            <p class="text-muted">
                                Periode: 
                                @if(request('start_date') && request('end_date'))
                                    {{ \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') }} - {{ \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') }}
                                @else
                                    Semua Periode
                                @endif
                            </p>
                        </div>

                        <!-- Tabel Laporan -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Tanggal</th>
                                        <th>No. Transaksi</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                        <th>Harga Satuan</th>
                                        <th>Total Nilai</th>
                                        <th>Bidang Tujuan</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalNilai = 0;
                                        $counter = 1;
                                    @endphp
                                    
                                    @forelse($barangKeluar as $item)
                                        @php
                                            $totalItem = $item->jumlah * $item->barang->harga_satuan;
                                            $totalNilai += $totalItem;
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $counter++ }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d/m/Y') }}</td>
                                            <td>{{ $item->no_transaksi }}</td>
                                            <td>{{ $item->barang->nama_barang }}</td>
                                            <td class="text-end">{{ number_format($item->jumlah) }}</td>
                                            <td class="text-center">{{ $item->barang->satuan }}</td>
                                            <td class="text-end">Rp {{ number_format($item->barang->harga_satuan, 0, ',', '.') }}</td>
                                            <td class="text-end">Rp {{ number_format($totalItem, 0, ',', '.') }}</td>
                                            <td>{{ $item->bidang_tujuan }}</td>
                                            <td>{{ $item->keterangan ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center py-4 text-muted">
                                                <i class="fas fa-box-open fa-2x mb-3"></i>
                                                <p>Tidak ada data barang keluar</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                    
                                    @if($barangKeluar->count() > 0)
                                        <tr class="table-success fw-bold">
                                            <td colspan="7" class="text-end">TOTAL NILAI:</td>
                                            <td class="text-end">Rp {{ number_format($totalNilai, 0, ',', '.') }}</td>
                                            <td colspan="2"></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Tanda Tangan -->
                        <div class="row mt-5">
                            <div class="col-md-6 text-center">
                                <div class="mb-3">
                                    <strong>PIHAK PERTAMA</strong><br>
                                    <small class="text-muted">Yang Menyerahkan</small>
                                </div>
                                <div style="height: 100px;"></div>
                                <div class="border-top pt-2">
                                    <strong>{{ Auth::user()->name ?? 'Nama Pihak Pertama' }}</strong><br>
                                    <small class="text-muted">NIP. {{ Auth::user()->nip ?? '123456789' }}</small>
                                </div>
                            </div>
                            <div class="col-md-6 text-center">
                                <div class="mb-3">
                                    <strong>PIHAK KEDUA</strong><br>
                                    <small class="text-muted">Yang Menerima</small>
                                </div>
                                <div style="height: 100px;"></div>
                                <div class="border-top pt-2">
                                    <strong>_________________________</strong><br>
                                    <small class="text-muted">NIP. ___________________</small>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Tambahan -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="mb-3"><i class="fas fa-info-circle me-2"></i>Informasi:</h6>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <small><strong>Total Transaksi:</strong> {{ $barangKeluar->count() }}</small>
                                            </div>
                                            <div class="col-md-4">
                                                <small><strong>Total Barang Keluar:</strong> {{ number_format($barangKeluar->sum('jumlah')) }} item</small>
                                            </div>
                                            <div class="col-md-4">
                                                <small><strong>Total Nilai:</strong> Rp {{ number_format($totalNilai, 0, ',', '.') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div> <!-- End Body -->

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .border-light-custom { border:1px solid #e3f2fd; border-radius:0.75rem; }
    .shadow-soft { box-shadow:0 0.125rem 0.75rem rgba(0,0,0,0.075) !important; }
    
    @media print {
        .card-header, .btn, .form-control, .form-select { display: none !important; }
        .card { border: none !important; box-shadow: none !important; }
        .table { font-size: 12px; }
        #laporanContent { margin: 0; padding: 0; }
    }
</style>
@endpush

@push('scripts')
<script>
    function printLaporan() {
        window.print();
    }

    function exportPDF() {
        // Simulasi export PDF - dalam implementasi real, ini akan memanggil backend
        alert('Fitur export PDF akan diimplementasikan di backend');
        
        // Contoh implementasi dengan jsPDF (require library jsPDF)
        /*
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        
        // Ambil HTML content
        const element = document.getElementById('laporanContent');
        
        // Convert ke PDF
        doc.html(element, {
            callback: function (doc) {
                doc.save('laporan-barang-keluar.pdf');
            },
            x: 10,
            y: 10,
            width: 190,
            windowWidth: 800
        });
        */
    }

    // Auto set tanggal default jika tidak ada filter
    document.addEventListener('DOMContentLoaded', function() {
        const startDate = document.querySelector('input[name="start_date"]');
        const endDate = document.querySelector('input[name="end_date"]');
        
        if (!startDate.value) {
            // Set default ke awal bulan
            const firstDay = new Date();
            firstDay.setDate(1);
            startDate.value = firstDay.toISOString().split('T')[0];
        }
        
        if (!endDate.value) {
            // Set default ke hari ini
            endDate.value = new Date().toISOString().split('T')[0];
        }
    });
</script>
@endpush





