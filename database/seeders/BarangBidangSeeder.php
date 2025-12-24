<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BarangBidangSeeder extends Seeder
{
    public function run()
    {
        // Pastikan kolom bidang_kode ada
        if (!Schema::hasColumn('barang', 'bidang_kode')) {
            $this->command->error('Kolom bidang_kode tidak ditemukan di tabel barang.');
            return;
        }

        // Update semua barang yang belum ada bidang_kode
        $barangWithoutBidang = Barang::whereNull('bidang_kode')
            ->orWhere('bidang_kode', '')
            ->get();

        $bidangCodes = ['SKT', 'PKP', 'KDL', 'RR'];

        foreach ($barangWithoutBidang as $barang) {
            $barang->update([
                'bidang_kode' => $bidangCodes[array_rand($bidangCodes)]
            ]);
        }

        $this->command->info('Berhasil update ' . $barangWithoutBidang->count() . ' barang.');

        // Data contoh baru SESUAI struktur tabel
        $barangContoh = [
            [
                'bidang_kode' => 'SKT',
                'kode_barang' => 'SKT-001',
                'nama_barang' => 'Kertas A4 70gr',
                'jenis_barang' => 'pakai_habis',
                'kategori_id' => 1,
                'satuan_id' => 1,    // pastikan ini ada di tabel satuan
                'stok_minimal' => 5,
                'stok' => 50,
                'harga_satuan' => 45000,
                'keterangan' => 'Kertas HVS A4 70gr',
                'status' => 1
            ],
            [
                'bidang_kode' => 'PKP',
                'kode_barang' => 'PKP-001',
                'nama_barang' => 'Life Jacket',
                'jenis_barang' => 'aset_tetap',
                'kategori_id' => 2,
                'satuan_id' => 1,
                'stok_minimal' => 10,
                'stok' => 25,
                'harga_satuan' => 250000,
                'keterangan' => 'Pelampung keselamatan',
                'status' => 1
            ],
        ];

        foreach ($barangContoh as $data) {
            $exists = Barang::where('kode_barang', $data['kode_barang'])->first();

            if (!$exists) {
                Barang::create($data);
                $this->command->info('Barang contoh dibuat: ' . $data['kode_barang']);
            }
        }
    }
}
