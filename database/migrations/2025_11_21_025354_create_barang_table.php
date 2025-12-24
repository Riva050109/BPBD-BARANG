<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();

            // Identitas utama
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');

            // Relasi kategori & satuan (boleh null)
            $table->unsignedBigInteger('kategori_id')->nullable();
            $table->unsignedBigInteger('satuan_id')->nullable();

            // Jenis barang
            $table->enum('kategori_barang', ['Habis Pakai', 'Aset Tetap'])
                ->default('Habis Pakai');

            // Stok akan berubah otomatis dari transaksi masuk & keluar
            $table->integer('stok')->default(0);

            // Harga dasar barang
            $table->decimal('harga_satuan', 15, 2)->default(0);

            // Informasi tambahan
            $table->integer('stok_minimal')->default(0);
            $table->text('keterangan')->nullable();

            // Status aktif/tidak
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barang');
    }
};
