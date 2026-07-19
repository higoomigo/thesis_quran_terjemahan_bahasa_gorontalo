<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('riwayat_terjemahans', function (Blueprint $table) {
            // Nambahin kolom alasan_revisi setelah kolom teks_baru
            $table->text('alasan_revisi')->nullable()->after('teks_baru');
        });
    }

    public function down(): void
    {
        Schema::table('riwayat_terjemahans', function (Blueprint $table) {
            $table->dropColumn('alasan_revisi');
        });
    }
};