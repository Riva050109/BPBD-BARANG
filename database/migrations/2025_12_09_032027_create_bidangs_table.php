<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bidangs', function (Blueprint $table) {
            $table->string('kode', 3)->primary(); // SKT, PKP, KDL, RR
            $table->string('nama');
            $table->string('deskripsi')->nullable();
            $table->string('penanggung_jawab');
            $table->string('icon')->default('building');
            $table->string('color')->default('primary');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // Insert data default
        DB::table('bidangs')->insert([
            [
                'kode' => 'SKT',
                'nama' => 'SEKRETARIAT',
                'deskripsi' => 'Bidang Administrasi dan Umum',
                'penanggung_jawab' => 'Sekretaris',
                'icon' => 'building',
                'color' => 'primary',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => 'PKP',
                'nama' => 'BIDANG PENCEGAHAN DAN KESIAPSIAGAAN',
                'deskripsi' => 'Bidang Pencegahan dan Mitigasi',
                'penanggung_jawab' => 'Kepala Bidang Pencegahan',
                'icon' => 'shield-alt',
                'color' => 'success',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => 'KDL',
                'nama' => 'BIDANG KEDARURATAN DAN LOGISTIK',
                'deskripsi' => 'Bidang Tanggap Darurat',
                'penanggung_jawab' => 'Kepala Bidang Kedaruratan',
                'icon' => 'ambulance',
                'color' => 'warning',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => 'RR',
                'nama' => 'BIDANG REHABILITASI DAN REKONSTRUKSI',
                'deskripsi' => 'Bidang Pemulihan Pasca Bencana',
                'penanggung_jawab' => 'Kepala Bidang Rehabilitasi',
                'icon' => 'home',
                'color' => 'info',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('bidangs');
    }
};