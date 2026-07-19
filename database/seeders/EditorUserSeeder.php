<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EditorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pakai updateOrCreate biar aman kalau di-run berkali-kali
        User::updateOrCreate(
            ['email' => 'tim_editor@gorontalo.com'], // Acuan pencarian
            [
                'name' => 'Editor Terjemahan Gorontalo',
                'password' => Hash::make('password'), // Password default
                'role' => 'editor', // Pastikan nama kolom ini sesuai dengan tabel users lu
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@quranhulontalo.com'], // Acuan pencarian
            [
                'name' => 'Admin Quran Hulontalo', // Nama user
                'password' => Hash::make('password'), // Password default
                'role' => 'admin', // Pastikan nama kolom ini sesuai dengan tabel users lu
            ]
        );
        
        // Boleh tambah editor kedua kalau lu butuh lebih dari satu akun buat testing
        User::updateOrCreate(
            ['email' => 'editor2@sakinah.com'],
            [
                'name' => 'Editor Bahasa',
                'password' => Hash::make('password123'),
                'role' => 'editor',
            ]
        );
    }
}