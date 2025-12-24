<?php

namespace Database\Seeders;

use App\Models\Bidang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BidangSeeder extends Seeder
{
    public function run(): void
    {
        // Data bidang sesuai dengan migration
        $bidangs = [
            [
                'kode' => 'SKT',
                'nama' => 'SEKRETARIAT',
                'deskripsi' => 'Bidang Administrasi dan Umum',
                'penanggung_jawab' => 'Sekretaris',
                'icon' => 'building',
                'color' => 'primary',
                'aktif' => true,
            ],
            [
                'kode' => 'PKP',
                'nama' => 'BIDANG PENCEGAHAN DAN KESIAPSIAGAAN',
                'deskripsi' => 'Bidang Pencegahan dan Mitigasi',
                'penanggung_jawab' => 'Kepala Bidang Pencegahan',
                'icon' => 'shield-alt',
                'color' => 'success',
                'aktif' => true,
            ],
            [
                'kode' => 'KDL',
                'nama' => 'BIDANG KEDARURATAN DAN LOGISTIK',
                'deskripsi' => 'Bidang Tanggap Darurat',
                'penanggung_jawab' => 'Kepala Bidang Kedaruratan',
                'icon' => 'ambulance',
                'color' => 'warning',
                'aktif' => true,
            ],
            [
                'kode' => 'RR',
                'nama' => 'BIDANG REHABILITASI DAN REKONSTRUKSI',
                'deskripsi' => 'Bidang Pemulihan Pasca Bencana',
                'penanggung_jawab' => 'Kepala Bidang Rehabilitasi',
                'icon' => 'home',
                'color' => 'info',
                'aktif' => true,
            ],
            [
                'kode' => 'LOG',
                'nama' => 'BIDANG LOGISTIK',
                'deskripsi' => 'Bidang Pengelolaan Logistik',
                'penanggung_jawab' => 'Kepala Bidang Logistik',
                'icon' => 'box',
                'color' => 'secondary',
                'aktif' => true,
            ],
        ];

        foreach ($bidangs as $bidang) {
            Bidang::updateOrCreate(
                ['kode' => $bidang['kode']], // Cari berdasarkan kode
                $bidang // Update atau create dengan data ini
            );
        }

        $this->command->info('✅ Data bidang berhasil disimpan!');
    }
}