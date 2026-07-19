<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('usulan_terjemahans', function (Blueprint $table) {
            // Menambahkan kolom baru setelah kolom catatan_pakar biar rapi urutannya
            
            $table->timestamp('validated_at')->nullable()->after('batas_waktu_diskusi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usulan_terjemahans', function (Blueprint $table) {
            // Kalau migrasi di-rollback, kolom ini bakal dihapus
            $table->dropColumn([
                'validated_at'
            ]);
        });
    }
};