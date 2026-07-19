<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Fitur: Mengubah ENUM menjadi VARCHAR agar data lama ('teologi', 'linguistik') aman
     * dan kita bisa menambahkan role baru ('editor') tanpa harus migration baru lagi.
     */
    public function up(): void
    {
        // Mengubah kolom role menjadi VARCHAR, collate ut8mb4_unicode_ci
        // Data 'teologi' & 'linguistik' aman 100%, role 'editor' siap masuk.
        DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * Fitur: Mengembalikan struktur VARCHAR menjadi ENUM awal (tanpa 'editor')
     */
    public function down(): void
    {
        // Jika di-rollback, kembalikan ke struktur ENUM awal yang lu punya
        // Data 'teologi' & 'linguistik' tetap aman, tapi 'editor' akan jadi NULL/Error jika tidak dihapus.
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('teologi', 'linguistik', 'admin') COLLATE utf8mb4_unicode_ci DEFAULT NULL");
    }
};