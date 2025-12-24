<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('barang', function (Blueprint $table) {

            // Tambah kolom hanya jika belum ada
            if (!Schema::hasColumn('barang', 'bidang_kode')) {
                $table->string('bidang_kode', 10)->nullable();
            }

            // Tambah index (optional)
            $table->index('bidang_kode');
        });
    }

    public function down()
    {
        Schema::table('barang', function (Blueprint $table) {
            if (Schema::hasColumn('barang', 'bidang_kode')) {
                $table->dropColumn('bidang_kode');
            }
        });
    }
};
