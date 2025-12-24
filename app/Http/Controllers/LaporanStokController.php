<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class LaporanStokController extends Controller
{
    public function index()
    {
        // Menggunakan query builder untuk laporan stok
        $stokBarang = Barang::selectRaw('
            barang.id,
            barang.kode_barang,
            barang.nama_barang,
            barang.satuan,
            COALESCE(SUM(barang_masuk.jumlah), 0) as total_masuk,
            COALESCE(SUM(barang_keluar.jumlah), 0) as total_keluar,
            (COALESCE(SUM(barang_masuk.jumlah), 0) - COALESCE(SUM(barang_keluar.jumlah), 0)) as stok_sisa,
            barang.keterangan
        ')
        ->leftJoin('barang_masuk', 'barang.id', '=', 'barang_masuk.barang_id')
        ->leftJoin('barang_keluar', 'barang.id', '=', 'barang_keluar.barang_id')
        ->groupBy('barang.id', 'barang.kode_barang', 'barang.nama_barang', 'barang.satuan', 'barang.keterangan')
        ->get();

        return view('laporan.stok', compact('stokBarang'));
    }
}