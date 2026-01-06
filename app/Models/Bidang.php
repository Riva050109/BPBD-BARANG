<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    protected $table = 'bidangs'; // ⬅️ PENTING
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'penanggung_jawab',
        'icon',
        'color',
        'aktif'
    ];
}
