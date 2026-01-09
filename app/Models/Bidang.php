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

    public function barang()
{
    return $this->hasMany(Barang::class, 'bidang_kode', 'kode');
}


public function index()
{
    $bidangs = Bidang::withCount('barang')->get();

    return view('data-entry.barang.index', compact('bidangs'));
}
}
