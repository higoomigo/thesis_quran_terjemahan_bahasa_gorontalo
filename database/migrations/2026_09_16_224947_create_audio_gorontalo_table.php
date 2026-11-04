<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audio_gorontalos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ayat_id')->constrained('ayats')->cascadeOnDelete();
            
            // Relasi khusus pembaca terjemahan Gorontalo
            $table->foreignId('pembaca_gorontalo_id')->constrained('pelantuns')->cascadeOnDelete();
            
            // File path khusus Gorontalo
            $table->string('file_path');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audio_gorontalos');
    }
};