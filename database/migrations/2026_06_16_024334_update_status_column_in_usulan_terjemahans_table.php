<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah struktur ENUM untuk memasukkan 'dipublikasi'
        DB::statement("ALTER TABLE usulan_terjemahans MODIFY COLUMN status ENUM('menunggu', 'diterima', 'ditolak', 'dipublikasi') DEFAULT 'menunggu'");
    }

    public function down(): void
    {
        // Kembalikan ke asal jika migration di-rollback
        DB::statement("ALTER TABLE usulan_terjemahans MODIFY COLUMN status ENUM('menunggu', 'diterima', 'ditolak') DEFAULT 'menunggu'");
    }
};