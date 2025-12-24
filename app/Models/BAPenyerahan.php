<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BAPenyerahan extends Model
{
    protected $table = 'ba_penyerahan'; // nama tabel

    protected $fillable = [
        'barang_id',
        'penerima',
        'bidang',
        'jumlah',
        'tanggal',
        'keterangan'
    ];

    // Relasi ke barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
