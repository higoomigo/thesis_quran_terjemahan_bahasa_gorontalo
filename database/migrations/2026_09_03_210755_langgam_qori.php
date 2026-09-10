<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('langgam_pelantun', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke tabel langgams
            $table->foreignId('langgam_id')->constrained('langgams')->onDelete('cascade');
            
            // Foreign key ke tabel pelantuns
            $table->foreignId('pelantun_id')->constrained('pelantuns')->onDelete('cascade'); 
            // Catatan: sesuaikan nama tabel 'pelantun' dengan yang ada di database lu (bisa 'pelantuns' atau 'pelantun')

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('langgam_pelantun');
    }
};