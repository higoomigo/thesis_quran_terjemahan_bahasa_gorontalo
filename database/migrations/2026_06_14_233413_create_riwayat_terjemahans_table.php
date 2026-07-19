<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_terjemahans', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel ayats (kalau ayat dihapus, riwayatnya ikut kehapus)
            $table->foreignId('ayat_id')->constrained('ayats')->cascadeOnDelete();
            
            // Relasi ke tabel usulans (biar ketahuan riwayat ini berasal dari usulan siapa)
            $table->foreignId('usulan_id')->nullable()->constrained('usulan_terjemahans')->nullOnDelete();
            
            // Relasi ke tabel users (mencatat siapa Editor yang ngetuk palu)
            $table->foreignId('editor_id')->nullable()->constrained('users')->nullOnDelete();
            
            // Teks sebelum diubah (bisa kosong kalau sebelumnya memang belum ada terjemahan)
            $table->text('teks_lama')->nullable(); 
            
            // Teks setelah diubah oleh Editor
            $table->text('teks_baru'); 
            
            $table->timestamps(); // Mencatat kapan perubahan ini terjadi
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_terjemahans');
    }
};