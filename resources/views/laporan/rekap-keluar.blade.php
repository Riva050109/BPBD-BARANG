@extends('layouts.app')

@section('title', 'Laporan Rekap Barang Keluar')

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
                <form action="{{ route('laporan.rekap-keluar') }}" method="GET" id="filterForm">
                    <div class="row">

                        <div class="col-md-4">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" name="start_date"
                                value="{{ $start_date ?? date('Y-m-01') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" name="end_date"
                                value="{{ $end_date ?? date('Y-m-t') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Bidang</label>
                            <select class="form-select" name="bidang">
                                <option value="">Semua Bidang</option>
                                <option value="pencegahan">Pencegahan & Kesiapsiagaan</option>
                                <option value="penanggulangan">Penanggulangan Bencana</option>
                                <option value="rehabilitasi">Rehabilitasi & Rekonstruksi</option>
                                <option value="logistik">Logistik & Peralatan</option>
                            </select>
                        </div>

                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-1"></i> Terapkan Filter
                        </button>

                        <button type="button" class="btn btn-outline-secondary" onclick="resetFilter()">
                            <i class="fas fa-refresh me-1"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>

       

    </div>
</div>
@endsection

@push('scripts')
<script>
    function resetFilter() {
        document.getElementById('filterForm').reset();
        window.location.href = "{{ route('laporan.rekap-keluar') }}";
    }
</script>
@endpush
