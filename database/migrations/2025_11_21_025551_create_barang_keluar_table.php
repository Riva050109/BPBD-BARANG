<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_keluar');
            $table->enum('jenis_bidang', ['sekretariat', 'pencegahan', 'kedaruratan', 'rehabilitasi']);
            $table->foreignId('barang_id')->constrained('barang')->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('kategori_barang')->onDelete('cascade');
            $table->integer('jumlah');
            $table->string('satuan');
            $table->string('bidang_tujuan');
            $table->decimal('harga_satuan', 15, 2);
            $table->text('keterangan')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barang_keluar');
    }
};