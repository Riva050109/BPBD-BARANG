@extends('layouts.app')

@section('title', 'Laporan Saldo Awal')
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

        {{-- FILTER --}}
        <div class="card shadow-soft border-light-custom mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0 text-gradient">Filter Laporan</h6>
            </div>

            <div class="card-body">
                <form action="{{ route('laporan.saldo-awal') }}" method="GET" id="filterForm">
                    <div class="row">

                        {{-- Jenis Laporan --}}
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Jenis Laporan</label>
                                <select class="form-select" name="jenis" id="jenisLaporan">
                                    <option value="keseluruhan" {{ $jenisLaporan == 'keseluruhan' ? 'selected' : '' }}>
                                        Rekap Keseluruhan
                                    </option>
                                    <option value="bidang" {{ $jenisLaporan == 'bidang' ? 'selected' : '' }}>
                                        Rekap per Bidang
                                    </option>
                                </select>
                            </div>
                        </div>

                        {{-- Bidang --}}
                        <div class="col-md-4" id="bidangField"
                            style="{{ $jenisLaporan == 'bidang' ? '' : 'display:none;' }}">
                            <div class="mb-3">
                                <label class="form-label">Pilih Bidang</label>
                                <select class="form-select" name="bidang">
                                    <option value="semua" {{ $bidang == 'semua' ? 'selected' : '' }}>Semua</option>
                                    <option value="sekretariat" {{ $bidang == 'sekretariat' ? 'selected' : '' }}>SEKRETARIAT</option>
                                    <option value="pencegahan" {{ $bidang == 'pencegahan' ? 'selected' : '' }}>PENCEGAHAN & KESIAPSIAGAAN</option>
                                    <option value="kedaruratan" {{ $bidang == 'kedaruratan' ? 'selected' : '' }}>KEDARURATAN & LOGISTIK</option>
                                    <option value="rehabilitasi" {{ $bidang == 'rehabilitasi' ? 'selected' : '' }}>REHABILITASI & REKONSTRUKSI</option>
                                </select>
                            </div>
                        </div>

                        {{-- Periode --}}
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Periode</label>
                                <input type="month" class="form-control" name="periode" value="{{ $periode }}">
                            </div>
                        </div>

                    </div>

                    <div class="mt-2">
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
document.getElementById('jenisLaporan').addEventListener('change', function () {
    const bidangField = document.getElementById('bidangField');
    bidangField.style.display = this.value === 'bidang' ? 'block' : 'none';
    document.getElementById('filterForm').submit();
});

function resetFilter() {
    window.location.href = "{{ route('laporan.saldo-awal') }}";
}
</script>
@endpush
