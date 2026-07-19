<?php
// database/migrations/2025_01_15_000001_create_usulan_terjemahans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usulan_terjemahans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ayat_id')->constrained('ayats')->onDelete('cascade');
            $table->string('nama_pengusul', 100);
            $table->string('no_hp', 20);
            $table->text('usulan_teks');
            $table->enum('status', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->text('catatan_pakar')->nullable();
            $table->timestamps();
            
            // Index untuk performa query
            $table->index(['ayat_id', 'status']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usulan_terjemahans');
    }
};