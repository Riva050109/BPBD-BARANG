@extends('layouts.app')

@section('title', 'Barang Keluar')
@section('icon', '')

@section('content')
<div class="container-fluid px-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-sign-out-alt text-danger me-2"></i>
                Data Barang Keluar
            </h1>
        </div>
        <a href="{{ route('barang-keluar.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Input Barang Keluar
        </a>
    </div>

    <!-- Alert -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Table -->
    <div class="card shadow border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Tanggal</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Bidang Tujuan</th>
                            <th>Total Nilai</th>
                            <th>User</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($barangKeluar as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($barangKeluar->currentPage()-1)*$barangKeluar->perPage() }}</td>
                            <td>{{ $item->no_transaksi }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d/m/Y') }}</td>
                            <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                            <td>{{ number_format($item->jumlah) }} {{ $item->barang->satuan ?? '' }}</td>
                            <td>{{ $item->bidang_tujuan }}</td>
                            <td>Rp {{ number_format($item->total_nilai, 0, ',', '.') }}</td>
                            <td>{{ $item->user->name ?? '-' }}</td>
                            <td>
                                <a href="{{ route('barang-keluar.show', $item->id) }}" 
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <form action="{{ route('barang-keluar.destroy', $item->id) }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">
                                Data barang keluar belum tersedia
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $barangKeluar->links() }}
            </div>
        </div>
    </div>

</div>
@endsection
