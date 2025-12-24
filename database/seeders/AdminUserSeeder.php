<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Cek apakah admin sudah ada
        if (!User::where('email', 'admin@bpbd.com')->exists()) {
            User::create([
                'name' => 'Administrator BPBD',
                'email' => 'admin@bpbd.com',
                'password' => Hash::make('admin123'), // Ganti dengan password yang aman
                'role' => 'admin',
            ]);
            $this->command->info('Admin user created successfully!');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}