<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->enum('jenis_barang', ['pakai_habis', 'aset_tetap'])
                  ->default('pakai_habis')
                  ->after('nama_barang');
        });
    }

    public function down()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->dropColumn('jenis_barang');
        });
    }
};