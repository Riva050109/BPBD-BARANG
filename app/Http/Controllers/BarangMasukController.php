<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Support\Facades\DB;
use App\Models\Bidang;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    /**
     * =============================
     * INDEX – DAFTAR BARANG MASUK
     * =============================
     */
    public function index(Request $request)
    {
        $query = BarangMasuk::with(['barang', 'user']);

        // Filter tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_masuk', [
                $request->start_date,
                $request->end_date
            ]);
        }

        // Filter bidang
        if ($request->filled('bidang')) {
    $query->whereHas('barang', function ($q) use ($request) {
        $q->where('bidang_kode', $request->bidang);
    });
}


        $barangMasuk = $query
            ->orderBy('tanggal_masuk', 'desc')
            ->paginate(10);

        $bidang = Bidang::all();

        return view('data-entry.barang-masuk.index', compact('barangMasuk', 'bidang'));
    }

    /**
     * =============================
     * CREATE – FORM BARANG MASUK
     * =============================
     */
   public function create()
{
    $bidang = Bidang::all();
    $barang = Barang::orderBy('kode_barang')->get();

    return view('data-entry.barang-masuk.create', compact('bidang', 'barang'));
}

    /**
     * =============================
     * STORE – SIMPAN BARANG MASUK
     * =============================
     */
  public function store(Request $request)
{
    $request->validate([
        'barang_id'     => 'required|exists:barang,id',
        'tanggal_masuk' => 'required|date',
        'jumlah'        => 'required|integer|min:1',
        'harga_satuan'  => 'required|numeric|min:0',
    ]);

    DB::transaction(function () use ($request) {

        BarangMasuk::create([
            'barang_id'     => $request->barang_id,
            'tanggal_masuk' => $request->tanggal_masuk,
            'jumlah'        => $request->jumlah,
            'harga_satuan'  => $request->harga_satuan,
            'keterangan'    => $request->keterangan,
        ]);

        $barang = Barang::findOrFail($request->barang_id);
        $barang->increment('stok', $request->jumlah);
    });

    return redirect()
        ->route('barang-masuk.index')
        ->with('success', 'Barang masuk berhasil disimpan');
}



    /**
     * =============================
     * SHOW – DETAIL BARANG MASUK
     * =============================
     */
    public function show($id)
    {
        $barangMasuk = BarangMasuk::with(['barang', 'user'])->findOrFail($id);
        return view('data-entry.barang-masuk.show', compact('barangMasuk'));
    }

    /**
     * =============================
     * EDIT – FORM EDIT
     * =============================
     */
    public function edit($id)
    {
        $barangMasuk = BarangMasuk::with('barang')->findOrFail($id);
        return view('data-entry.barang-masuk.edit', compact('barangMasuk'));
    }

    /**
     * =============================
     * UPDATE – UPDATE DATA
     * =============================
     */
   public function update(Request $request, $id)
{
    $barangMasuk = BarangMasuk::with('barang')->findOrFail($id);

    $validated = $request->validate([
        'tanggal_masuk' => 'required|date',
        'jumlah' => 'required|integer|min:1',
        'harga_satuan' => 'required|integer|min:0',
        'total_nilai' => 'required|integer|min:0',
        'keterangan' => 'nullable|string',
    ]);

    // Hitung selisih stok
    $selisih = $validated['jumlah'] - $barangMasuk->jumlah;

    $barangMasuk->barang->stok += $selisih;
    $barangMasuk->barang->save();

    // Update transaksi
    $barangMasuk->update($validated);

    return redirect()
        ->route('barang-masuk.index')
        ->with('success', 'Data barang masuk berhasil diperbarui');
}


    /**
     * =============================
     * DESTROY – HAPUS DATA
     * =============================
     */
    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::with('barang')->findOrFail($id);

        // Kurangi stok
        $barangMasuk->barang->stok -= $barangMasuk->jumlah;
        $barangMasuk->barang->save();

        // Hapus transaksi
        $barangMasuk->delete();

        return redirect()
            ->route('barang-masuk.index')
            ->with('success', 'Data barang masuk berhasil dihapus');
    }

    /**
     * =================================================
     * API – AMBIL BARANG BERDASARKAN KODE (AJAX)
     * =================================================
     */
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
                'harga_satuan' => $barang->harga_satuan,
                'kategori' => $barang->kategori->nama_kategori ?? '',
                'jenis_barang' => $barang->jenis_barang,
                'stok' => $barang->stok,
            ]
        ]);
    }
}
