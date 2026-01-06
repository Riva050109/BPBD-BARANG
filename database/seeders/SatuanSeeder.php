<?php

namespace Database\Seeders;

use App\Models\Satuan;
use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
{
    public function run(): void
    {
        $satuans = [
            ['kode_satuan' => 'UNIT',   'nama_satuan' => 'Unit',   'deskripsi' => 'Satuan unit'],
            ['kode_satuan' => 'BUAH',   'nama_satuan' => 'Buah',   'deskripsi' => 'Satuan buah'],
            ['kode_satuan' => 'PACK',   'nama_satuan' => 'Pack',   'deskripsi' => 'Satuan pack'],
            ['kode_satuan' => 'DUS',    'nama_satuan' => 'Dus',    'deskripsi' => 'Satuan dus'],
            ['kode_satuan' => 'BOX',    'nama_satuan' => 'Box',    'deskripsi' => 'Satuan box'],
            ['kode_satuan' => 'SET',    'nama_satuan' => 'Set',    'deskripsi' => 'Satuan set'],
            ['kode_satuan' => 'LUSIN',  'nama_satuan' => 'Lusin',  'deskripsi' => 'Satuan lusin'],
            ['kode_satuan' => 'RIM',    'nama_satuan' => 'Rim',    'deskripsi' => 'Satuan rim'],
            ['kode_satuan' => 'BTG',    'nama_satuan' => 'Batang', 'deskripsi' => 'Satuan batang'],
            ['kode_satuan' => 'BUKU',   'nama_satuan' => 'Buku',   'deskripsi' => 'Satuan buku'],
        ];

        foreach ($satuans as $satuan) {
            Satuan::create([
                'kode_satuan' => $satuan['kode_satuan'],
                'nama_satuan' => $satuan['nama_satuan'],
                'deskripsi'   => $satuan['deskripsi'],
                'status'      => true,
            ]);
        }
    }
}
