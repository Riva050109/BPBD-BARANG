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
    $bidang = Bidang::all();
    $bidangKode = request('bidang');

    $kategories = KategoriBarang::all();
    $jenisBarang = JenisBarang::all();
    $satuan = Satuan::all();

    // 🔧 FIX ERROR: barang dikirim (kosong)
    $barang = collect();

    return view('data-entry.barang.create', compact(
        'bidang',
        'bidangKode',
        'kategories',
        'jenisBarang',
        'satuan',
        'barang'
    ));
}

 public function index()
    {
        $barang = Barang::all(); // atau paginate
        return view('data-entry.barang.index', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bidang_kode' => 'required|exists:bidang,kode_bidang',
            'kode_barang' => 'required|string|max:50|unique:barang,kode_barang',
            'nama_barang' => 'required|string|max:255',
            'jenis_barang' => 'required|in:pakai_habis,aset_tetap',
            'kategori_id' => 'nullable|exists:kategori_barang,id',
            'satuan' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
            'harga_satuan' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string'
        ]);

        Barang::create([
            'bidang_kode' => $request->bidang_kode,
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'jenis_barang' => $request->jenis_barang,
            'kategori_id' => $request->kategori_id,
            'satuan' => $request->satuan,
            'stok' => $request->stok,
            'harga_satuan' => $request->harga_satuan,
            'keterangan' => $request->keterangan,
            'is_active' => true
        ]);

        return redirect()
            ->route('bidang.show', $request->bidang_kode)
            ->with('success', 'Barang berhasil ditambahkan.');
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

    public function getByKode($kode)
    {
        $barang = Barang::with('kategori')
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
                'id' => $barang->id,
                'kode_barang' => $barang->kode_barang,
                'nama_barang' => $barang->nama_barang,
                'satuan' => $barang->satuan,
                'kategori' => $barang->kategori->nama_kategori ?? '',
                'jenis_barang' => $barang->jenis_barang,
                'harga_satuan' => $barang->harga_satuan,
            ]
        ]);
    }
}
