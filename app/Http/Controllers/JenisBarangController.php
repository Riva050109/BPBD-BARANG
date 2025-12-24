<?php

namespace App\Http\Controllers;

use App\Models\JenisBarang;
use Illuminate\Http\Request;

class JenisBarangController extends Controller
{
    public function index()
    {
        $jenisBarang = JenisBarang::latest()->get();
        return view('parameter.jenis-barang.index', compact('jenisBarang'));
    }

    public function create()
    {
        return view('parameter.jenis-barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_jenis' => 'required|string|max:10|unique:jenis_barang,kode_jenis',
            'nama_jenis' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        JenisBarang::create([
            'kode_jenis' => strtoupper($request->kode_jenis),
            'nama_jenis' => $request->nama_jenis,
            'deskripsi' => $request->deskripsi,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('jenis-barang.index')
            ->with('success', 'Jenis barang berhasil ditambahkan');
    }

    public function show(JenisBarang $jenisBarang)
    {
        return view('parameter.jenis-barang.show', compact('jenisBarang'));
    }

    public function edit(JenisBarang $jenisBarang)
    {
        return view('parameter.jenis-barang.edit', compact('jenisBarang'));
    }

    public function update(Request $request, JenisBarang $jenisBarang)
    {
        $request->validate([
            'kode_jenis' => 'required|string|max:10|unique:jenis_barang,kode_jenis,' . $jenisBarang->id,
            'nama_jenis' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        $jenisBarang->update([
            'kode_jenis' => strtoupper($request->kode_jenis),
            'nama_jenis' => $request->nama_jenis,
            'deskripsi' => $request->deskripsi,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('jenis-barang.index')
            ->with('success', 'Jenis barang berhasil diperbarui');
    }

    public function destroy(JenisBarang $jenisBarang)
    {
        // Cek apakah jenis barang digunakan di barang
        if ($jenisBarang->barang()->count() > 0) {
            return redirect()->route('jenis-barang.index')
                ->with('error', 'Jenis barang tidak dapat dihapus karena masih digunakan di data barang');
        }

        $jenisBarang->delete();

        return redirect()->route('jenis-barang.index')
            ->with('success', 'Jenis barang berhasil dihapus');
    }
}