<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $totalKategori = KategoriBarang::count();
        $totalMasuk = BarangMasuk::count();
        $totalKeluar = BarangKeluar::count();
        
        // Barang habis stok
        $stokHabis = Barang::where('stok', 0)->count();

        // Barang menipis (misal stok <= 5)
        $stokMenipis = Barang::where('stok', '>', 0)
                             ->where('stok', '<=', 5)
                             ->count();

        // Statistik bulanan
        $bulanIni = Carbon::now();
        $barangMasukBulanIni = BarangMasuk::whereMonth('tanggal_masuk', $bulanIni->month)
                                          ->whereYear('tanggal_masuk', $bulanIni->year)
                                          ->count();
        
        $barangKeluarBulanIni = BarangKeluar::whereMonth('tanggal_keluar', $bulanIni->month)
                                            ->whereYear('tanggal_keluar', $bulanIni->year)
                                            ->count();

        // Grafik 6 bulan terakhir
        $chartData = $this->getChartData();

        // Data terbaru
        $barangMasukTerbaru = BarangMasuk::with(['barang'])->latest()->take(5)->get();
        $barangKeluarTerbaru = BarangKeluar::with(['barang'])->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalBarang', 
            'totalKategori',
            'totalMasuk', 
            'totalKeluar',
            'stokMenipis',
            'stokHabis',
            'barangMasukBulanIni',
            'barangKeluarBulanIni',
            'chartData',
            'barangMasukTerbaru',
            'barangKeluarTerbaru'
        ));
    }

    private function getChartData()
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $bulan = $date->format('M Y');
            
            $masuk = BarangMasuk::whereMonth('tanggal_masuk', $date->month)
                                 ->whereYear('tanggal_masuk', $date->year)
                                 ->count();
            
            $keluar = BarangKeluar::whereMonth('tanggal_keluar', $date->month)
                                   ->whereYear('tanggal_keluar', $date->year)
                                   ->count();
            
            $data[] = [
                'bulan' => $bulan,
                'masuk' => $masuk,
                'keluar' => $keluar
            ];
        }
        
        return $data;
    }
}
