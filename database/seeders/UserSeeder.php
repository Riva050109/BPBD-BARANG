<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\KategoriBarang;
use App\Models\Supplier;
use App\Models\Barang;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // User Admin
        User::create([
            'name' => 'Administrator BPBD',
            'email' => 'admin@bpbd.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // User Biasa
        User::create([
            'name' => 'Operator BPBD',
            'email' => 'operator@bpbd.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Kategori Barang BPBD
        KategoriBarang::create([
            'kode_kategori' => 'LOG-001',
            'nama_kategori' => 'Peralatan Logistik',
            'jenis' => 'aset_tetap',
            'deskripsi' => 'Peralatan logistik untuk penanggulangan bencana'
        ]);

        KategoriBarang::create([
            'kode_kategori' => 'MED-001',
            'nama_kategori' => 'Peralatan Medis',
            'jenis' => 'pakai_habis',
            'deskripsi' => 'Peralatan dan obat-obatan medis'
        ]);

        KategoriBarang::create([
            'kode_kategori' => 'EVAC-001',
            'nama_kategori' => 'Peralatan Evakuasi',
            'jenis' => 'aset_tetap',
            'deskripsi' => 'Peralatan untuk evakuasi korban'
        ]);

        // Supplier
        Supplier::create([
            'kode_supplier' => 'SUP-001',
            'nama_supplier' => 'CV. Mitra Logistik',
            'telepon' => '021-123456',
            'alamat' => 'Jl. Logistik No. 123, Jakarta',
            'email' => 'mitra@logistik.com',
            'keterangan' => 'Supplier peralatan logistik'
        ]);

        // Data Barang Contoh BPBD
        Barang::create([
            'kode_barang' => 'BRG-LOG-001',
            'nama_barang' => 'Tenda Darurat',
            'kategori_id' => 1,
            'bidang' => 'logistik',
            'jenis_barang' => 'aset_tetap',
            'stok_minimum' => 5,
            'stok_awal' => 20,
            'stok_sekarang' => 20,
            'satuan' => 'unit',
            'harga_satuan' => 2500000,
            'keterangan' => 'Tenda untuk pengungsian'
        ]);

        Barang::create([
            'kode_barang' => 'BRG-MED-001',
            'nama_barang' => 'P3K Kit',
            'kategori_id' => 2,
            'bidang' => 'kesehatan',
            'jenis_barang' => 'pakai_habis',
            'stok_minimum' => 50,
            'stok_awal' => 100,
            'stok_sekarang' => 100,
            'satuan' => 'kit',
            'harga_satuan' => 150000,
            'keterangan' => 'Perlengkapan P3K standar'
        ]);

        Barang::create([
            'kode_barang' => 'BRG-EVAC-001',
            'nama_barang' => 'Perahu Karet',
            'kategori_id' => 3,
            'bidang' => 'evakuasi',
            'jenis_barang' => 'aset_tetap',
            'stok_minimum' => 3,
            'stok_awal' => 10,
            'stok_sekarang' => 10,
            'satuan' => 'unit',
            'harga_satuan' => 15000000,
            'keterangan' => 'Perahu karet untuk evakuasi banjir'
        ]);

        Barang::create([
            'kode_barang' => 'BRG-KOM-001',
            'nama_barang' => 'HT Handy Talky',
            'kategori_id' => 1,
            'bidang' => 'komunikasi',
            'jenis_barang' => 'aset_tetap',
            'stok_minimum' => 10,
            'stok_awal' => 25,
            'stok_sekarang' => 25,
            'satuan' => 'unit',
            'harga_satuan' => 800000,
            'keterangan' => 'Alat komunikasi lapangan'
        ]);

        echo "User admin created:\n";
        echo "Email: admin@bpbd.com\n";
        echo "Password: password\n\n";
    }
}