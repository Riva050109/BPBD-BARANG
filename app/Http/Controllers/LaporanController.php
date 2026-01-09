<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Bidang;
use App\Models\BAPenyerahan;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Laporan Saldo Awal
     */
    public function saldoAwal(Request $request)
    { 
        $jenisLaporan = $request->get('jenis', 'keseluruhan');
        $bidang = $request->get('bidang', 'semua');
        $periode = $request->get('periode', date('Y-m'));
        
        $data = Barang::all();
        $rekap = [];
        $bidangs = Bidang::orderBy('nama')->get();

        if ($jenisLaporan === 'bidang') {
            $rekap = DB::table('barang')
                ->leftJoin('barang_masuk', function ($q) use ($periode) {
                    $q->on('barang_masuk.barang_id', '=', 'barang.id')
                      ->where('barang_masuk.tanggal_masuk', 'like', "$periode%");
                })
                ->leftJoin('barang_keluar', function ($q) use ($periode, $bidang) {
                    $q->on('barang_keluar.barang_id', '=', 'barang.id')
                      ->where('barang_keluar.tanggal_keluar', 'like', "$periode%");

                    if ($bidang !== 'semua') {
                        $q->where('barang_keluar.bidang', $bidang);
                    }
                })
               ->select(
    'barang.id',
    'barang.kode_barang',
    'barang.nama_barang',
    'barang.jenis_barang',

    DB::raw('COALESCE(SUM(barang_masuk.jumlah), 0) AS masuk'),
    DB::raw('COALESCE(SUM(barang_keluar.jumlah), 0) AS keluar'),
    DB::raw('(COALESCE(SUM(barang_masuk.jumlah), 0) - COALESCE(SUM(barang_keluar.jumlah), 0)) AS sisa'),

    DB::raw('COALESCE(SUM(barang_masuk.jumlah * barang_masuk.harga_satuan), 0) AS total_masuk'),
    DB::raw('COALESCE(SUM(barang_keluar.jumlah * barang_keluar.harga_satuan), 0) AS total_keluar'),

    DB::raw('
        (COALESCE(SUM(barang_masuk.jumlah * barang_masuk.harga_satuan), 0)
        - COALESCE(SUM(barang_keluar.jumlah * barang_keluar.harga_satuan), 0)) AS nilai_sisa
    ')
)

                ->groupBy(
    'barang.id',
    'barang.kode_barang',
    'barang.nama_barang',
    'barang.jenis_barang'
)

                ->orderBy('barang.kode_barang')
                ->get();
        } else {
            // Laporan keseluruhan (non-bidang)
            $rekap = DB::table('barang')
                ->leftJoin('barang_masuk', function ($q) use ($periode) {
                    $q->on('barang_masuk.barang_id', '=', 'barang.id')
                      ->where('barang_masuk.tanggal_masuk', 'like', "$periode%");
                })
                ->leftJoin('barang_keluar', function ($q) use ($periode) {
                    $q->on('barang_keluar.barang_id', '=', 'barang.id')
                      ->where('barang_keluar.tanggal_keluar', 'like', "$periode%");
                })
               ->select(
    'barang.id',
    'barang.kode_barang',
    'barang.nama_barang',
    'barang.jenis_barang',

    DB::raw('COALESCE(SUM(barang_masuk.jumlah), 0) AS masuk'),
    DB::raw('COALESCE(SUM(barang_keluar.jumlah), 0) AS keluar'),
    DB::raw('(COALESCE(SUM(barang_masuk.jumlah), 0) - COALESCE(SUM(barang_keluar.jumlah), 0)) AS sisa')
)

                ->groupBy(
    'barang.id',
    'barang.kode_barang',
    'barang.nama_barang',
    'barang.jenis_barang'
)

                ->orderBy('barang.kode_barang')
                ->get();
        }

        return view('laporan.saldo-awal', compact(
            'jenisLaporan', 'bidang', 'periode', 'data', 'rekap', 'bidangs'
        ));
    }

    /**
     * Rekap Barang Masuk
     */
    public function rekapMasuk(Request $request)
    {
        $start_date = $request->get('start_date', date('Y-m-01'));
        $end_date = $request->get('end_date', date('Y-m-d'));

        $rekap = DB::table('barang_masuk')
            ->leftJoin('barang', 'barang.id', '=', 'barang_masuk.barang_id')
            ->select(
    'barang_masuk.*',
    'barang.kode_barang',
    'barang.nama_barang',
    DB::raw('(barang_masuk.jumlah * barang_masuk.harga_satuan) as total_nilai')
)

            ->whereBetween('barang_masuk.tanggal_masuk', [$start_date, $end_date])
            ->orderBy('barang_masuk.tanggal_masuk', 'asc')
            ->get();

        return view('laporan.rekap-masuk', [
            'rekap' => $rekap,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'total_nilai' => $rekap->sum('total_nilai'),
            'rekap_count' => $rekap->count(),
            'suppliers' => [],
        ]);
    }

    /**
     * Rekap Barang Keluar
     */
    public function rekapKeluar(Request $request)
    {
        $rekap = DB::table('barang_keluar')
            ->join('barang', 'barang_keluar.barang_id', '=', 'barang.id')
            ->select(
                'barang_keluar.*',
                'barang.nama_barang'
                // Hapus kategori jika kolom tidak ada
                // 'barang.kategori'
            )
            ->orderBy('barang_keluar.tanggal_keluar', 'asc')
            ->get();

        return view('laporan.rekap-keluar', compact('rekap'));
    }

    /**
     * BA Penyerahan
     */
    public function laporanBAPenyerahan(Request $request)
    {
        $tanggal_awal = $request->tanggal_awal ?? date('Y-m-01');
        $tanggal_akhir = $request->tanggal_akhir ?? date('Y-m-d');
        $bidang = $request->bidang ?? 'all';

        $bidangOptions = [
            'all' => 'Semua Bidang',
            'Sekretariat' => 'Sekretariat',
            'Bidang Pencegahan/Kesiapsiagaan' => 'Bidang Pencegahan/Kesiapsiagaan',
            'Bidang Kedaruratan/Logistik' => 'Bidang Kedaruratan/Logistik',
            'Bidang Rehabilitasi/Rekontruksi' => 'Bidang Rehabilitasi/Rekonstruksi',
        ];

        $query = BAPenyerahan::query()
            ->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir]);

        if ($bidang !== 'all') {
            $query->where('bidang', $bidang);
        }

        $baData = $query->orderBy('tanggal', 'asc')->get()
            ->groupBy('tanggal');

        return view('laporan.ba-penyerahan', compact(
            'tanggal_awal',
            'tanggal_akhir',
            'bidang',
            'bidangOptions',
            'baData'
        ));
    }
}