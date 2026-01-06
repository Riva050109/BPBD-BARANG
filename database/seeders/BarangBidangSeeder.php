<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BarangBidangSeeder extends Seeder
{
    public function run()
    {
        // ===============================
        // CEK KOLUMN WAJIB
        // ===============================
        if (!Schema::hasColumn('barang', 'bidang_kode')) {
            $this->command->error('Kolom bidang_kode tidak ditemukan di tabel barang.');
            return;
        }

        // ===============================
        // UPDATE DATA LAMA YANG BELUM ADA BIDANG
        // ===============================
        $bidangCodes = ['SKT', 'PKP', 'KDL', 'RR'];

        $barangWithoutBidang = Barang::whereNull('bidang_kode')
            ->orWhere('bidang_kode', '')
            ->get();

        foreach ($barangWithoutBidang as $barang) {
            $barang->update([
                'bidang_kode' => $bidangCodes[array_rand($bidangCodes)]
            ]);
        }

        $this->command->info(
            'Update bidang_kode pada ' . $barangWithoutBidang->count() . ' barang lama.'
        );

        // ===============================
        // DATA CONTOH (SESUAI CONTROLLER)
        // ===============================
        $barangContoh = [
            [
                'bidang_kode'  => 'SKT',
                'kode_barang'  => 'SKT-PH-0001',
                'nama_barang'  => 'Kertas A4 70gr',
                'jenis_barang' => 'pakai_habis',
                'kategori_id'  => 1,
                'satuan'       => 'rim',
                'stok'         => 50,
                'harga_satuan' => 45000,
                'keterangan'   => 'Kertas HVS A4 70gr',
                
            ],
            [
                'bidang_kode'  => 'PKP',
                'kode_barang'  => 'PKP-AT-0001',
                'nama_barang'  => 'Life Jacket',
                'jenis_barang' => 'aset_tetap',
                'kategori_id'  => 2,
                'satuan'       => 'unit',
                'stok'         => 25,
                'harga_satuan' => 250000,
                'keterangan'   => 'Pelampung keselamatan',
               
            ],
        ];

        foreach ($barangContoh as $data) {
            Barang::firstOrCreate(
                ['kode_barang' => $data['kode_barang']],
                $data
            );

            $this->command->info('Barang contoh dipastikan ada: ' . $data['kode_barang']);
        }

        $this->command->info('Seeder BarangBidangSeeder selesai.');
    }
}
