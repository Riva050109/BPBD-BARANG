<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SatuanController extends Controller
{
    public function index()
    {
        // Cek apakah tabel satuan ada
        $tableName = $this->getSatuanTableName();
        
        if (!$tableName) {
            // Tabel tidak ditemukan, tampilkan view dengan data kosong
            return view('satuan.index', [
                'satuans' => collect([]),
                'totalSatuan' => 0,
                'totalPakai' => 0,
                'totalAset' => 0
            ]);
        }
        
        // Cek kolom yang tersedia
        $columns = Schema::getColumnListing($tableName);
        
        // Ambil data dengan orderBy yang sesuai
        if (in_array('nama_satuan', $columns)) {
            $satuans = DB::table($tableName)->orderBy('nama_satuan')->get();
        } elseif (in_array('nama', $columns)) {
            $satuans = DB::table($tableName)->orderBy('nama')->get();
        } elseif (in_array('satuan', $columns)) {
            $satuans = DB::table($tableName)->orderBy('satuan')->get();
        } else {
            $satuans = DB::table($tableName)->get();
        }
        
        // Hitung statistik
        $totalSatuan = $satuans->count();
        
        // Cek kolom untuk jenis satuan
        $jenisColumn = $this->getJenisColumn($columns);
        
        if ($jenisColumn) {
            $totalPakai = $satuans->where($jenisColumn, 'pakai_habis')->count();
            $totalAset = $satuans->where($jenisColumn, 'aset_tetap')->count();
        } else {
            $totalPakai = 0;
            $totalAset = 0;
        }
        
        return view('parameter.satuan.index', compact('satuans', 'totalSatuan', 'totalPakai', 'totalAset'));
    }
    
    private function getSatuanTableName()
    {
        // Cek kemungkinan nama tabel
        $possibleTables = ['satuans', 'satuan', 'm_satuan', 'master_satuan'];
        
        foreach ($possibleTables as $table) {
            if (Schema::hasTable($table)) {
                return $table;
            }
        }
        
        return null;
    }
    
    private function getJenisColumn($columns)
    {
        // Cek kemungkinan nama kolom untuk jenis
        $possibleColumns = ['jenis_satuan', 'jenis', 'tipe', 'type', 'category'];
        
        foreach ($possibleColumns as $column) {
            if (in_array($column, $columns)) {
                return $column;
            }
        }
        
        return null;
    }
    
    public function create()
    {
        return view('parameter.satuan.create');
    }
    
    public function store(Request $request)
    {
        $tableName = $this->getSatuanTableName();
        
        if (!$tableName) {
            return redirect()->route('satuan.index')
                ->with('error', 'Tabel satuan belum tersedia');
        }
        
        $columns = Schema::getColumnListing($tableName);
        $data = [];
        
        // Mapping field form ke kolom tabel
        $fieldMapping = [
            'nama_satuan' => ['nama_satuan', 'nama', 'satuan', 'name'],
            'jenis_satuan' => ['jenis_satuan', 'jenis', 'tipe'],
            'simbol' => ['simbol', 'symbol', 'singkatan'],
            'deskripsi' => ['deskripsi', 'keterangan', 'description'],
            'kategori' => ['kategori', 'category'],
            'status' => ['status', 'is_active', 'aktif']
        ];
        
        foreach ($fieldMapping as $field => $possibleColumns) {
            foreach ($possibleColumns as $column) {
                if (in_array($column, $columns) && $request->has($field)) {
                    $data[$column] = $request->$field;
                    break;
                }
            }
        }
        
        // Tambahkan timestamp
        if (in_array('created_at', $columns)) {
            $data['created_at'] = now();
        }
        if (in_array('updated_at', $columns)) {
            $data['updated_at'] = now();
        }
        
        DB::table($tableName)->insert($data);
        
        return redirect()->route('satuan.index')
            ->with('success', 'Satuan berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        $tableName = $this->getSatuanTableName();
        
        if (!$tableName) {
            return redirect()->route('satuan.index')
                ->with('error', 'Tabel satuan belum tersedia');
        }
        
        $satuan = DB::table($tableName)->find($id);
        
        if (!$satuan) {
            return redirect()->route('satuan.index')
                ->with('error', 'Satuan tidak ditemukan');
        }
        
        return view('satuan.edit', compact('satuan'));
    }
    
    public function update(Request $request, $id)
    {
        $tableName = $this->getSatuanTableName();
        
        if (!$tableName) {
            return redirect()->route('satuan.index')
                ->with('error', 'Tabel satuan belum tersedia');
        }
        
        $columns = Schema::getColumnListing($tableName);
        $data = [];
        
        // Mapping field form ke kolom tabel
        $fieldMapping = [
            'nama_satuan' => ['nama_satuan', 'nama', 'satuan', 'name'],
            'jenis_satuan' => ['jenis_satuan', 'jenis', 'tipe'],
            'simbol' => ['simbol', 'symbol', 'singkatan'],
            'deskripsi' => ['deskripsi', 'keterangan', 'description'],
            'kategori' => ['kategori', 'category'],
            'status' => ['status', 'is_active', 'aktif']
        ];
        
        foreach ($fieldMapping as $field => $possibleColumns) {
            foreach ($possibleColumns as $column) {
                if (in_array($column, $columns) && $request->has($field)) {
                    $data[$column] = $request->$field;
                    break;
                }
            }
        }
        
        // Update timestamp
        if (in_array('updated_at', $columns)) {
            $data['updated_at'] = now();
        }
        
        DB::table($tableName)->where('id', $id)->update($data);
        
        return redirect()->route('satuan.index')
            ->with('success', 'Satuan berhasil diperbarui');
    }
    
    public function destroy($id)
    {
        $tableName = $this->getSatuanTableName();
        
        if (!$tableName) {
            return redirect()->route('satuan.index')
                ->with('error', 'Tabel satuan belum tersedia');
        }
        
        DB::table($tableName)->where('id', $id)->delete();
        
        return redirect()->route('satuan.index')
            ->with('success', 'Satuan berhasil dihapus');
    }
    
    public function export()
    {
        $tableName = $this->getSatuanTableName();
        
        if (!$tableName) {
            return response()->json(['message' => 'Tabel tidak ditemukan'], 404);
        }
        
        $satuans = DB::table($tableName)->get();
        
        return response()->json([
            'message' => 'Export berhasil',
            'data' => $satuans
        ]);
    }
}   