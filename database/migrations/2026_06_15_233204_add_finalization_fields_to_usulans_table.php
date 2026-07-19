<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usulan_terjemahans', function (Blueprint $table) {
            $table->text('teks_rekomendasi')->nullable()->after('usulan_teks');
            $table->text('alasan_revisi')->nullable()->after('teks_rekomendasi');
            // $table->text('catatan_pakar')->nullable()->after('alasan_revisi');
        });
    }

    public function down(): void
    {
        Schema::table('usulan_terjemahans', function (Blueprint $table) {
            $table->dropColumn(['teks_rekomendasi', 'alasan_revisi']);
        });
    }
};
