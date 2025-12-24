<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kategori_barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kategori')->unique();
            $table->string('nama_kategori');
            $table->enum('jenis', ['pakai_habis', 'aset_tetap']);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kategori_barang');
    }
};