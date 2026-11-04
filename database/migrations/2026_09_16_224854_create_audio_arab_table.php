<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audio_arabs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ayat_id')->constrained('ayats')->cascadeOnDelete();
            
            // Relasi ke pelantun (Qari) dan langgam
            $table->foreignId('pelantun_id')->constrained('pelantuns')->cascadeOnDelete();
            $table->foreignId('langgam_id')->nullable()->constrained('langgams')->nullOnDelete();
            
            // File path khusus Arab
            $table->string('file_path');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audio_arabs');
    }
};