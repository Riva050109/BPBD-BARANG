<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = 'barang_keluar'; // Nama tabel di database
    
    protected $fillable = [
        'kode_transaksi',
        'barang_id',
        'jumlah',
        'tanggal_keluar',
        'penerima',
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