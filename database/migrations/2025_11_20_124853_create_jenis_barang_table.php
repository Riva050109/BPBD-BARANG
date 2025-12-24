<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_jenis')->unique();
            $table->string('nama_jenis');
            $table->text('deskripsi')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // Insert data default
        DB::table('jenis_barang')->insert([
            [
                'kode_jenis' => 'PH',
                'nama_jenis' => 'Barang Pakai Habis',
                'deskripsi' => 'Barang yang habis dalam satu kali penggunaan',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_jenis' => 'AT',
                'nama_jenis' => 'Barang Aset Tetap',
                'deskripsi' => 'Barang yang dapat digunakan berulang kali dan memiliki masa manfaat lebih dari 1 tahun',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_barang');
    }
};