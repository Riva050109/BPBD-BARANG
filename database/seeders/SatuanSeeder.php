<?php

namespace Database\Seeders;

use App\Models\Satuan;
use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
{
    public function run()
    {
        $satuans = [
            ['nama' => 'Unit',  'jenis_satuan' => 'pakai_habis', 'keterangan' => 'Satuan unit'],
            ['nama' => 'Buah',  'jenis_satuan' => 'pakai_habis', 'keterangan' => 'Satuan buah'],
            ['nama' => 'Pack',  'jenis_satuan' => 'pakai_habis', 'keterangan' => 'Satuan pack'],
            ['nama' => 'Dus',   'jenis_satuan' => 'pakai_habis', 'keterangan' => 'Satuan dus'],
            ['nama' => 'Box',   'jenis_satuan' => 'pakai_habis', 'keterangan' => 'Satuan box'],
            ['nama' => 'Set',   'jenis_satuan' => 'pakai_habis', 'keterangan' => 'Satuan set'],
            ['nama' => 'Lusin', 'jenis_satuan' => 'pakai_habis', 'keterangan' => 'Satuan lusin'],
            ['nama' => 'Rim',   'jenis_satuan' => 'pakai_habis', 'keterangan' => 'Satuan rim'],
            ['nama' => 'Batang','jenis_satuan' => 'pakai_habis', 'keterangan' => 'Satuan batang'],
            ['nama' => 'Buku',  'jenis_satuan' => 'pakai_habis', 'keterangan' => 'Satuan buku'],
        ];

        foreach ($satuans as $satuan) {
            Satuan::create($satuan);
        }
    }
}
