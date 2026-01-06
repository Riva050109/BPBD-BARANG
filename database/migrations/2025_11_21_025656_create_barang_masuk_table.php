<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id();

            $table->date('tanggal_masuk');

            $table->foreignId('barang_id')
                ->constrained('barang')
                ->cascadeOnDelete();

            $table->integer('jumlah');

            $table->decimal('harga_satuan', 15, 2);

            $table->decimal('total_nilai', 15, 2);

            $table->text('keterangan')->nullable();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barang_masuk');
    }
};
