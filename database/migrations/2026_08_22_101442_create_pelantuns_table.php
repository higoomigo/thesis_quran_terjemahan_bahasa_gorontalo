<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelantuns', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            // Menyimpan peran agar gampang difilter di form upload Editor
            $table->enum('peran', ['qari', 'pembaca_terjemahan', 'keduanya'])->default('qari');
            $table->string('foto')->nullable(); // Opsional, siapa tahu mau majang foto di halaman Lokal Murottal
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelantuns');
    }
};