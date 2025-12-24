<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    protected $table = 'satuan';
    
    protected $fillable = [
        'kode_satuan',
        'nama_satuan',
        'deskripsi',
        'status'
    ];
    
    protected $casts = [
        'status' => 'boolean'
    ];
    
    public function barang()
    {
        return $this->hasMany(Barang::class, 'satuan_id');
    }
}