@extends('layouts.app')

@section('title', 'Laporan Rekap Barang Masuk')
@section('icon', '')

@section('actions')
<div class="d-flex gap-2">
    <button class="btn btn-success btn-sm" onclick="window.print()">
        <i class="fas fa-print me-1"></i> Cetak
    </button>

    <a href="{{ route('laporan.rekap-masuk.export', request()->query()) }}" 
       class="btn btn-primary btn-sm">
        <i class="fas fa-download me-1"></i> Export
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">

        <!-- Filter -->
        <div class="card shadow-soft border-light-custom mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0">Filter Laporan</h6>
            </div>

            <div class="card-body">
                <form action="{{ route('laporan.rekap-masuk') }}" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control"
                                   value="{{ $start_date }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Tanggal Akhir</label>
                            <input type="date" name="end_date" class="form-control"
                                   value="{{ $end_date }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">
                        <i class="fas fa-filter me-1"></i> Terapkan Filter
                    </button>

                    <button type="button" class="btn btn-outline-secondary mt-3"
                            onclick="window.location.href='{{ route('laporan.rekap-masuk') }}'">
                        <i class="fas fa-refresh me-1"></i> Reset
                    </button>
                </form>
            </div>
        </div>

       
    </div>
</div>
@endsection
