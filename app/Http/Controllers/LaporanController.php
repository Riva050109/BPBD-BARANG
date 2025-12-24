<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Laporan Saldo Awal
     */
    public function saldoAwal(Request $request)
    {
        $jenisLaporan = $request->get('jenis', 'keseluruhan');
        $bidang       = $request->get('bidang', 'semua');
        $periode      = $request->get('periode', date('Y-m'));

        $data = Barang::with(['satuan', 'kategori'])->get();
        $rekap = [];

        if ($jenisLaporan === 'bidang') {

            $rekap = DB::table('barang')
                ->leftJoin('kategori_barang', 'kategori_barang.id', '=', 'barang.kategori_id')
                ->leftJoin('satuan', 'satuan.id', '=', 'barang.satuan_id')

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
                    'kategori_barang.nama_kategori',
                    'satuan.nama AS nama_satuan',

                    DB::raw('COALESCE(SUM(barang_masuk.jumlah), 0) AS masuk'),
                    DB::raw('COALESCE(SUM(barang_keluar.jumlah), 0) AS keluar'),

                    DB::raw('(COALESCE(SUM(barang_masuk.jumlah), 0) - COALESCE(SUM(barang_keluar.jumlah), 0)) AS sisa'),

                    DB::raw('COALESCE(SUM(barang_masuk.jumlah * barang_masuk.harga), 0) AS total_masuk'),
                    DB::raw('COALESCE(SUM(barang_keluar.jumlah * barang_keluar.harga), 0) AS total_keluar'),

                    DB::raw('
                        (COALESCE(SUM(barang_masuk.jumlah * barang_masuk.harga), 0)
                        - COALESCE(SUM(barang_keluar.jumlah * barang_keluar.harga), 0)) AS nilai_sisa'
                    )
                )

                ->groupBy(
                    'barang.id',
                    'barang.kode_barang',
                    'barang.nama_barang',
                    'barang.jenis_barang',
                    'kategori_barang.nama_kategori',
                    'satuan.nama'
                )
                ->orderBy('barang.kode_barang')
                ->get();
        }

        return view('laporan.saldo-awal', compact(
            'jenisLaporan','bidang','periode','data','rekap'
        ));
    }


    /**
     * Rekap Barang Masuk
     */
    public function rekapMasuk(Request $request)
    {
        $start_date = $request->get('start_date', date('Y-m-01'));
        $end_date   = $request->get('end_date', date('Y-m-d'));

        $rekap = DB::table('barang_masuk')
            ->leftJoin('barang', 'barang.id', '=', 'barang_masuk.barang_id')
            ->leftJoin('satuan', 'satuan.id', '=', 'barang.satuan_id')
            ->select(
                'barang_masuk.*',
                'barang.kode_barang',
                'barang.nama_barang',
                'satuan.nama as satuan_nama',
                DB::raw('(barang_masuk.jumlah * barang_masuk.harga) as total_nilai')
            )
            ->whereBetween('barang_masuk.tanggal_masuk', [$start_date, $end_date])
            ->orderBy('barang_masuk.tanggal_masuk', 'asc')
            ->get();

        return view('laporan.rekap-masuk', [
            'rekap'        => $rekap,
            'start_date'   => $start_date,
            'end_date'     => $end_date,
            'total_nilai'  => $rekap->sum('total_nilai'),
            'rekap_count'  => $rekap->count(),
            'suppliers'    => [],
        ]);
    }


    /**
     * Rekap Barang Keluar
     */
    public function rekapKeluar(Request $request)
    {
        $rekap = DB::table('barang_keluar')
            ->join('barang', 'barang_keluar.barang_id', '=', 'barang.id')
            ->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')
            ->select(
                'barang_keluar.*',
                'barang.nama_barang',
                'kategori_barang.nama_kategori'
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
    // Ambil filter (jika tidak ada, buat default)
    $tanggal_awal = $request->tanggal_awal ?? date('Y-m-01');
    $tanggal_akhir = $request->tanggal_akhir ?? date('Y-m-d');
    $bidang = $request->bidang ?? 'all';

    // Opsi bidang
    $bidangOptions = [
        'all' => 'Semua Bidang',
        'Sekretariat' => 'Sekretariat',
        'Bidang Pencegahan/Kesiapsiagaan' => 'Bidang Pencegahan/Kesiapsiagaan',
        'Bidang Kedaruratan/Logistik' => 'Bidang Kedaruratan/Logistik',
        'Bidang Rehabilitasi/Rekontruksi' => 'Bidng Rehabilitasi/Rekontruksi',
    ];

    // Query utama BA Penyerahan
    $query = \App\Models\BAPenyerahan::with(['barang.kategori'])
        ->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir]);

    if ($bidang !== 'all') {
        $query->where('bidang', $bidang);
    }

    $baData = $query->orderBy('tanggal', 'asc')->get()
        ->groupBy('tanggal'); // dikelompokkan per tanggal

    // Kirim ke view
    return view('laporan.ba-penyerahan', compact(
        'tanggal_awal',
        'tanggal_akhir',
        'bidang',
        'bidangOptions',
        'baData'
    ));
}


}
