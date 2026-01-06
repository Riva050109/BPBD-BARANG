<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = 'barang_keluar'; // Tambahkan ini
    
    protected $fillable = [
        'barang_id',
        'tanggal_keluar',
        'jumlah',
        'keterangan',
        'user_id'
        // sesuaikan dengan kolom migration
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}