<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    /**
     * Daftar barang keluar
     */
    public function index()
    {
        $barangKeluar = BarangKeluar::with(['barang', 'user'])
            ->latest()
            ->paginate(10);

        return view('data-entry.barang-keluar.index', compact('barangKeluar'));
    }

    /**
     * Form input barang keluar
     */
    public function create()
    {
        // Hanya barang dengan stok > 0
        $barang = Barang::with('kategori')
            ->where('stok', '>', 0)
            ->orderBy('nama_barang')
            ->get();

        $bidang = [
            'Sekretariat',
            'Pencegahan',
            'Kedaruratan',
            'Rehabilitasi'
        ];

        return view('data-entry.barang-keluar.create', compact('barang', 'bidang'));
    }

    /**
     * Simpan barang keluar
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_keluar' => 'required|date',
            'barang_id'      => 'required|exists:barang,id',
            'jumlah'         => 'required|integer|min:1',
            'bidang_tujuan'  => 'required|string|max:100',
            'keterangan'     => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Lock row agar aman dari race condition
            $barang = Barang::lockForUpdate()->findOrFail($validated['barang_id']);

            // Validasi stok
            if ($validated['jumlah'] > $barang->stok) {
                return back()
                    ->withErrors(['jumlah' => 'Stok tidak mencukupi. Stok tersedia: ' . $barang->stok])
                    ->withInput();
            }

            // Hitung total nilai
            $totalNilai = $validated['jumlah'] * ($barang->harga_satuan ?? 0);

            // Generate nomor transaksi
            $noTransaksi = 'BK-' . date('Ymd') . '-' . str_pad(
                BarangKeluar::whereDate('created_at', now()->toDateString())->count() + 1,
                4,
                '0',
                STR_PAD_LEFT
            );

            // Simpan barang keluar
            BarangKeluar::create([
                'no_transaksi'   => $noTransaksi,
                'tanggal_keluar' => $validated['tanggal_keluar'],
                'barang_id'      => $barang->id,
                'jumlah'         => $validated['jumlah'],
                'bidang_tujuan'  => $validated['bidang_tujuan'],
                'keterangan'     => $validated['keterangan'],
                'total_nilai'    => $totalNilai,
                'user_id'        => auth()->id(),
            ]);

            // Kurangi stok
            $barang->decrement('stok', $validated['jumlah']);

            DB::commit();

            return redirect()
                ->route('barang-keluar.index')
                ->with('success', 'Barang keluar berhasil disimpan');

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Detail barang keluar
     */
    public function show($id)
    {
        $barangKeluar = BarangKeluar::with(['barang.kategori', 'user'])
            ->findOrFail($id);

        return view('data-entry.barang-keluar.show', compact('barangKeluar'));
    }

    /**
     * Hapus barang keluar
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $barangKeluar = BarangKeluar::findOrFail($id);
            $barang = Barang::find($barangKeluar->barang_id);

            // Kembalikan stok
            if ($barang) {
                $barang->increment('stok', $barangKeluar->jumlah);
            }

            $barangKeluar->delete();

            DB::commit();

            return redirect()
                ->route('barang-keluar.index')
                ->with('success', 'Data barang keluar berhasil dihapus');

        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()
                ->route('barang-keluar.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
