<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usulan_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usulan_id')
                  ->constrained('usulan_terjemahans')
                  ->cascadeOnDelete();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->enum('keputusan', ['setuju', 'tolak']);
            $table->timestamps();

            // Satu user cuma boleh vote sekali per usulan
            $table->unique(['usulan_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usulan_votes');
    }
};