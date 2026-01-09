<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Bidang;
use App\Models\KategoriBarang;
use App\Models\JenisBarang;
use App\Models\Satuan;
use Illuminate\Http\Request;

class BarangController extends Controller
{
 
public function create()
{
    $bidangs = Bidang::all();
    $kategories = KategoriBarang::all();
    $jenisBarang = JenisBarang::all();
    $satuan = Satuan::all();

    return view('data-entry.barang.create', compact(
        'bidangs',
        'kategories',
        'jenisBarang',
        'satuan'
    ));
}




public function index()
{
    $bidangs = Bidang::all();

    return view('data-entry.barang.index', compact('bidangs'));
}
    public function show($id)   
    {
        $barang = Barang::with('kategori')->findOrFail($id);

        $totalNilai = $barang->stok * $barang->harga_satuan;

        $bidangInfo = [
            'SKT' => ['color' => 'primary', 'icon' => 'building', 'nama' => 'SEKRETARIAT'],
            'PKP' => ['color' => 'success', 'icon' => 'shield-alt', 'nama' => 'PENCEGAHAN'],
            'KDL' => ['color' => 'warning', 'icon' => 'ambulance', 'nama' => 'KEDARURATAN'],
            'RR'  => ['color' => 'info', 'icon' => 'home', 'nama' => 'REHABILITASI'],
        ];

        $bidangData = $bidangInfo[$barang->bidang_kode] ?? [
            'color' => 'secondary',
            'icon' => 'box',
            'nama' => $barang->bidang_kode
        ];

        $stokClass = $barang->stok < 10
            ? 'danger'
            : ($barang->stok < 50 ? 'warning' : 'success');

        return view('data-entry.barang.show', [
            'barang' => $barang,
            'totalNilai' => $totalNilai,
            'bidangColor' => $bidangData['color'],
            'bidangIcon' => $bidangData['icon'],
            'bidangNama' => $bidangData['nama'],
            'stokClass' => $stokClass
        ]);
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategories = KategoriBarang::all();
        $jenisBarang = JenisBarang::all();
        $satuan = Satuan::all();

        return view('data-entry.barang.edit', compact(
            'barang',
            'kategories',
            'jenisBarang',
            'satuan'
        ));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'kode_barang' => 'required|string|max:50|unique:barang,kode_barang,' . $id,
            'nama_barang' => 'required|string|max:255',
            'jenis_barang' => 'required|in:pakai_habis,aset_tetap',
            'kategori_id' => 'nullable|exists:kategori_barang,id',
            'satuan' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
            'harga_satuan' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string'
        ]);

        $barang->update($request->only([
            'kode_barang',
            'nama_barang',
            'jenis_barang',
            'kategori_id',
            'satuan',
            'stok',
            'harga_satuan',
            'keterangan'
        ]));

        return redirect()
            ->route('bidang.show', $barang->bidang_kode)
            ->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $bidangKode = $barang->bidang_kode;
        $barang->delete();

        return redirect()
            ->route('bidang.show', $bidangKode)
            ->with('success', 'Barang berhasil dihapus.');
    }

    // ================= AJAX =================

    public function getBarangByBidang($kode)
    {
        return Barang::where('bidang_kode', $kode)
            ->orderBy('nama_barang')
            ->get();
    }

public function byKode($kode)
{
    $barang = Barang::with(['satuan', 'kategori', 'bidang'])
        ->where('kode_barang', $kode)
        ->first();

    if (!$barang) {
        return response()->json([
            'success' => false,
            'message' => 'Barang tidak ditemukan'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => [
            'id' => $barang->id, // ⬅️ INI PENTING
            'nama_barang' => $barang->nama_barang,
            'satuan' => $barang->satuan->nama,
            'kategori' => $barang->kategori->nama,
            'harga_satuan' => $barang->harga_satuan,
            'bidang_kode' => $barang->bidang->kode,
            'bidang_nama' => $barang->bidang->nama,
        ]
    ]);
}
    public function store(Request $request)
{
    $request->validate([
        'bidang_kode' => 'required|exists:bidang,kode',
        'nama_barang' => 'required|string|max:255',
        'jenis_barang' => 'required|in:pakai_habis,aset_tetap',
        'kategori_barang' => 'required|string|max:100',
        'satuan' => 'required|string|max:50',
        'jumlah' => 'required|integer|min:1',
        'harga_satuan' => 'required|numeric|min:0',
        'keterangan' => 'nullable|string'
    ]);

    // map jenis
    $jenisMap = [
        'pakai_habis' => 'PH',
        'aset_tetap'  => 'AT',
    ];

    $nomorUrut = Barang::where('bidang_kode', $request->bidang_kode)
        ->where('jenis_barang', $request->jenis_barang)
        ->count() + 1;

    $kodeBarang = sprintf(
        '%s-%s-%04d',
        $request->bidang_kode,
        $jenisMap[$request->jenis_barang],
        $nomorUrut
    );

    Barang::create([
        'bidang_kode' => $request->bidang_kode,
        'kode_barang' => $kodeBarang,
        'nama_barang' => $request->nama_barang,
        'jenis_barang' => $request->jenis_barang,
        'kategori_barang' => $request->kategori_barang,
        'satuan' => $request->satuan,
        'stok' => $request->jumlah, // 🔥 PENTING
        'harga_satuan' => $request->harga_satuan,
        'keterangan' => $request->keterangan,
    ]);

    return redirect()
        ->route('barang-masuk.index')
        ->with('success', 'Barang masuk berhasil disimpan');
}


}
