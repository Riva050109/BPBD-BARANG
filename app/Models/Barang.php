<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori_id',
        'satuan_id', // atau 'satuan' jika pakai string
        'kategori_barang',
        'stok',
        'harga_satuan',
    
        'keterangan',
        'status'
    ];
    
    protected $casts = [
        'status' => 'boolean',
        'harga_satuan' => 'decimal:2'
    ];
    
    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_id');
    }
    
    // Relasi ke Satuan (jika ada model Satuan)
    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id');
    }
}