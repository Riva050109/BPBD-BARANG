<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // di file migrasi
public function up()
{
    Schema::table('barang', function (Blueprint $table) {
        $table->string('kategori')->nullable()->after('jenis_barang');
        $table->string('satuan')->nullable()->after('kategori');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            //
        });
    }
};
