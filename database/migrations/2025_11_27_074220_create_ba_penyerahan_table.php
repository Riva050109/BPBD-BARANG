<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ba_penyerahan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('bidang');
            $table->string('nama_barang');
            $table->integer('jumlah');
            $table->string('satuan');
            $table->text('keterangan')->nullable();
            $table->string('penerima');
            $table->string('penyerah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void  // ← PERBAIKAN: Hapus duplikasi 'function'
    {
        Schema::dropIfExists('ba_penyerahan');
    }
};