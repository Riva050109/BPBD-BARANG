<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class BidangController extends Controller
{
    /**
     * Halaman Index Semua Bidang
     */
    public function index()
    {
        // Pastikan tabel & kolom tersedia
        $hasBidangKode = Schema::hasColumn('barangs', 'bidang_kode');

        // Jika kolom belum ada, kembalikan nol semua
        if (!$hasBidangKode) {
            return view('data-entry.barang.index', [
                'totalBarangSekretariat'  => 0,
                'totalBarangPencegahan'   => 0,
                'totalBarangKedaruratan'  => 0,
                'totalBarangRehabilitasi' => 0,
                'totalNilaiSekretariat'   => 0,
                'totalNilaiPencegahan'    => 0,
                'totalNilaiKedaruratan'   => 0,
                'totalNilaiRehabilitasi'  => 0,
                'hasBidangKode'           => false
            ]);
        }

        // Hitung jumlah barang per bidang
        $totalBarangSekretariat  = Barang::where('bidang_kode', 'SKT')->count();
        $totalBarangPencegahan   = Barang::where('bidang_kode', 'PKP')->count();
        $totalBarangKedaruratan  = Barang::where('bidang_kode', 'KDL')->count();
        $totalBarangRehabilitasi = Barang::where('bidang_kode', 'RR')->count();

        // Hitung total nilai
        $totalNilaiSekretariat  = $this->hitungTotalNilai('SKT');
        $totalNilaiPencegahan   = $this->hitungTotalNilai('PKP');
        $totalNilaiKedaruratan  = $this->hitungTotalNilai('KDL');
        $totalNilaiRehabilitasi = $this->hitungTotalNilai('RR');

        return view('data-entry.barang.index', compact(
            'totalBarangSekretariat',
            'totalBarangPencegahan',
            'totalBarangKedaruratan',
            'totalBarangRehabilitasi',
            'totalNilaiSekretariat',
            'totalNilaiPencegahan',
            'totalNilaiKedaruratan',
            'totalNilaiRehabilitasi',
            'hasBidangKode'
        ));
    }

    /**
     * Halaman Detail per Bidang
     */
    public function show($kode)
    {
        if (!Schema::hasColumn('barangs', 'bidang_kode')) {
            return redirect()->route('data-entry.barang.index')
                ->with('warning', 'Kolom bidang_kode belum tersedia. Jalankan migrasi.');
        }

        $bidang = $this->getBidangData($kode);

        if (!$bidang) {
            abort(404, 'Bidang tidak ditemukan');
        }

        $barang = Barang::where('bidang_kode', $kode)
            ->with('kategori') // relasi kategori
            ->orderBy('nama_barang')
            ->get();

        $totalNilai = $barang->sum(fn ($item) => $item->stok * $item->harga_satuan);

        return view('data-entry.barang.show', compact('bidang', 'barang', 'totalNilai'));
    }

    /**
     * API JSON Barang per Bidang
     */
    public function getBarang($kode)
    {
        if (!Schema::hasColumn('barangs', 'bidang_kode')) {
            return response()->json([]);
        }

        $barang = Barang::where('bidang_kode', $kode)
            ->select(
                'id',
                'kode_barang',
                'nama_barang',
                'jenis_barang',
                'kategori_id',
                'satuan',
                'stok',
                'harga_satuan',
                'keterangan'
            )
            ->orderBy('nama_barang')
            ->get();

        return response()->json($barang);
    }

    /**
     * Hitung Total Nilai Barang per Bidang (lebih efisien)
     */
    private function hitungTotalNilai($kode)
    {
        if (!Schema::hasColumn('barangs', 'bidang_kode')) {
            return 0;
        }

        return Barang::where('bidang_kode', $kode)
            ->selectRaw('SUM(stok * harga_satuan) as total')
            ->value('total') ?? 0;
    }

    /**
     * Data Master Bidang
     */
    private function getBidangData($kode)
    {
        $list = $this->getBidangList();
        return $list[$kode] ?? null;
    }

    /**
     * Master List Bidang
     */
    private function getBidangList()
    {
        return [
            'SKT' => [
                'nama' => 'SEKRETARIAT',
                'kode' => 'SKT',
                'deskripsi' => 'Bidang Administrasi dan Umum',
                'penanggung_jawab' => 'Sekretaris',
                'icon' => 'building',
                'color' => 'primary'
            ],
            'PKP' => [
                'nama' => 'BIDANG PENCEGAHAN DAN KESIAPSIAGAAN',
                'kode' => 'PKP',
                'deskripsi' => 'Bidang Pencegahan dan Mitigasi',
                'penanggung_jawab' => 'Kepala Bidang Pencegahan',
                'icon' => 'shield-alt',
                'color' => 'success'
            ],
            'KDL' => [
                'nama' => 'BIDANG KEDARURATAN DAN LOGISTIK',
                'kode' => 'KDL',
                'deskripsi' => 'Bidang Tanggap Darurat',
                'penanggung_jawab' => 'Kepala Bidang Kedaruratan',
                'icon' => 'ambulance',
                'color' => 'warning'
            ],
            'RR' => [
                'nama' => 'BIDANG REHABILITASI DAN REKONSTRUKSI',
                'kode' => 'RR',
                'deskripsi' => 'Bidang Pemulihan Pasca Bencana',
                'penanggung_jawab' => 'Kepala Bidang Rehabilitasi',
                'icon' => 'home',
                'color' => 'info'
            ]
        ];
    }

    /**
     * API bidang JSON
     */
    public function getBidang()
    {
        return response()->json($this->getBidangList());
    }
}
