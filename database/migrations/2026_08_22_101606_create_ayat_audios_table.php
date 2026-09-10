<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ayat_audios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ayat_id')->constrained('ayats')->cascadeOnDelete();
            
            // Relasi ke langgam (misal: Bayati, atau Murottal Biasa)
            $table->foreignId('langgam_id')->constrained('langgams')->cascadeOnDelete();
            
            // Relasi ke pelantun (dipisah berdasarkan peran)
            $table->foreignId('qari_id')->nullable()->constrained('pelantuns')->nullOnDelete();
            $table->foreignId('pembaca_gorontalo_id')->nullable()->constrained('pelantuns')->nullOnDelete();
            
            // File Path
            $table->string('file_path_arab')->nullable();
            $table->string('file_path_gorontalo')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ayat_audios');
    }
};