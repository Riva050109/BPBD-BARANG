<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';

   protected $fillable = [
    'bidang_kode',
    'kode_barang',
    'nama_barang',
    'jenis_barang',
    'kategori_id',
    'satuan',
    'stok',
    'harga_satuan',
    'keterangan',
];


    protected $casts = [
        'is_active' => 'boolean',
        'harga_satuan' => 'decimal:2'
    ];

    // ================= RELASI =================

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_id');
    }

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class);
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class);
    }
}
