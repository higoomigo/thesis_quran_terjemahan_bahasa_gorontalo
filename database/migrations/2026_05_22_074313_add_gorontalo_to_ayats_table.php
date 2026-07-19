<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ayats', function (Blueprint $table) {
            // Menambah kolom teks_gorontalo setelah teksIndo
            $table->text('teks_gorontalo')->nullable()->after('teksIndo');
        });
    }

    public function down(): void
    {
        Schema::table('ayats', function (Blueprint $table) {
            $table->dropColumn('teks_gorontalo');
        });
    }
};