<?php

namespace App\Console\Commands;

use App\Models\Barang;
use Illuminate\Console\Command;

class UpdateBarangBidang extends Command
{
    protected $signature = 'barang:update-bidang';
    protected $description = 'Update bidang_kode untuk barang yang sudah ada';

    public function handle()
    {
        // Cek apakah kolom sudah ada
        if (!\Schema::hasColumn('barang', 'bidang_kode')) {
            $this->error('Kolom bidang_kode belum ada di tabel barang.');
            $this->info('Jalankan migrasi terlebih dahulu: php artisan migrate');
            return 1;
        }

        $this->info('Memulai update bidang barang...');
        
        // Update barang yang belum ada bidang_kode
        $updated = Barang::whereNull('bidang_kode')
            ->orWhere('bidang_kode', '')
            ->update(['bidang_kode' => 'SKT']); // Default ke Sekretariat
        
        $this->info("Berhasil update {$updated} barang dengan bidang default SKT");
        
        $this->info('Update selesai!');
        return 0;
    }
}