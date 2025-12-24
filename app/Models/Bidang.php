<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    protected $primaryKey = 'kode'; // Primary key adalah 'kode', bukan 'id'
    public $incrementing = false; // Karena primary key bukan auto-increment
    protected $keyType = 'string'; // Tipe data primary key adalah string

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'penanggung_jawab',
        'icon',
        'color',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean'
    ];
}