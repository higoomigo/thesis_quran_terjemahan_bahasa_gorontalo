<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ayat_audios', function (Blueprint $table) {
            // Ubah langgam_id dan qari_id menjadi boleh kosong (nullable)
            $table->unsignedBigInteger('langgam_id')->nullable()->change();
            
            // Aing sekalian tambahin qari_id biar nggak error juga pas upload Gorontalo
            if (Schema::hasColumn('ayat_audios', 'qari_id')) {
                $table->unsignedBigInteger('qari_id')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('ayat_audios', function (Blueprint $table) {
            // Kembalikan ke NOT NULL jika di-rollback
            $table->unsignedBigInteger('langgam_id')->nullable(false)->change();
            
            if (Schema::hasColumn('ayat_audios', 'qari_id')) {
                $table->unsignedBigInteger('qari_id')->nullable(false)->change();
            }
        });
    }
};
