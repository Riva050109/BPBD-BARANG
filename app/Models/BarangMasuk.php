<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $table = 'barang_masuk'; // Nama tabel di database
    
    protected $fillable = [
        'kode_transaksi',
        'barang_id',
        'jumlah',
        'tanggal_masuk',
        'supplier',
        'keterangan'
    ];

    /**
     * Relasi ke Barang
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}