<table class="table table-bordered table-striped table-hover align-middle">
    <thead class="table-primary text-center">
        <tr>
            <th style="width: 40px">No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Bidang</th>
            <th>Kategori Barang</th>
            <th>Satuan</th>
            <th>Masuk</th>
            <th>Keluar</th>
            <th>Sisa</th>
            <th>Harga Satuan</th>
            <th>Total Nilai</th>
        </tr>
    </thead>

    <tbody>
        @forelse($data as $row)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $row->kode_barang }}</td>
            <td>{{ $row->nama_barang }}</td>
            <td>{{ $row->satuan->nama ?? '-' }}</td>

            
            <td class="text-end text-success fw-semibold">{{ number_format($row->masuk) }}</td>
            <td class="text-end text-danger fw-semibold">{{ number_format($row->keluar) }}</td>
            <td class="text-end fw-bold">{{ number_format($row->sisa) }}</td>

            <td class="text-end">
                Rp {{ number_format($row->harga_satuan, 0, ',', '.') }}
            </td>

            <td class="text-end fw-bold">
                Rp {{ number_format($row->sisa * $row->harga_satuan, 0, ',', '.') }}
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="10" class="text-center py-3 text-muted">
                Tidak ada data untuk ditampilkan.
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
