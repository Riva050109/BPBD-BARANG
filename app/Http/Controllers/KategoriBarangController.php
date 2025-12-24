<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use Illuminate\Http\Request;

class KategoriBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $kategori = KategoriBarang::all();
        return view('parameter.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('parameter.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kategori' => 'required|unique:kategori_barang',
            'nama_kategori' => 'required',
            'jenis' => 'required|in:pakai_habis,aset_tetap'
        ]);

        KategoriBarang::create($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function show(KategoriBarang $kategori)
    {
        return view('parameter.kategori.show', compact('kategori'));
    }

    public function edit(KategoriBarang $kategori)
    {
        return view('parameter.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, KategoriBarang $kategori)
    {
        $request->validate([
            'kode_kategori' => 'required|unique:kategori_barang,kode_kategori,' . $kategori->id,
            'nama_kategori' => 'required',
            'jenis' => 'required|in:pakai_habis,aset_tetap'
        ]);

        $kategori->update($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(KategoriBarang $kategori)
    {
        if ($kategori->barang()->count() > 0) {
            return redirect()->route('kategori.index')->with('error', 'Tidak dapat menghapus kategori yang memiliki barang');
        }

        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}