<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    // ⭐⭐⭐ TAMBAHKAN BARIS INI ⭐⭐⭐
    protected $table = 'barang_masuk'; // Nama tabel tanpa 's'
    
    protected $fillable = [
        'barang_id',
        'tanggal_masuk',
        'jumlah',
        'harga_satuan',
        'total_nilai',
        'keterangan',
        'user_id'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}