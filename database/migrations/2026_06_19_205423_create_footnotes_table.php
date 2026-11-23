<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('footnotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ayat_id')->constrained('ayats')->cascadeOnDelete();
            $table->unsignedInteger('nomor');
            $table->enum('bahasa', ['indonesia', 'gorontalo'])->default('indonesia');
            $table->text('isi');
            $table->timestamps();

            $table->unique(['ayat_id', 'bahasa', 'nomor']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('footnotes');
    }
};