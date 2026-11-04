<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE usulan_terjemahans MODIFY COLUMN status ENUM('menunggu', 'menunggu_validasi', 'diterima', 'ditolak', 'dipublikasi') DEFAULT 'menunggu'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE usulan_terjemahans MODIFY COLUMN status ENUM('menunggu', 'diterima', 'ditolak', 'dipublikasi') DEFAULT 'menunggu'");
        }
    }
};