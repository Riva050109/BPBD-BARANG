<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->enum('bidang', [
                'logistik',
                'kesehatan', 
                'sarpras',
                'evakuasi',
                'komunikasi',
                'lainnya'
            ])->default('lainnya')->after('kategori_id');
        });
    }

    public function down()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->dropColumn('bidang');
        });
    }
};