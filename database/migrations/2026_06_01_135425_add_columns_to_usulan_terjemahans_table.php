<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsulanTerjemahansTable extends Migration
{
    public function up()
    {
        Schema::table('usulan_terjemahans', function (Blueprint $table) {
            // Tambahkan kolom batas waktu diskusi (opsional, bisa null)
            if (!Schema::hasColumn('usulan_terjemahans', 'batas_waktu_diskusi')) {
                $table->timestamp('batas_waktu_diskusi')->nullable()->after('catatan_pakar');
            }
            
            // Tambahkan kolom catatan linguistik
            if (!Schema::hasColumn('usulan_terjemahans', 'catatan_linguistik')) {
                $table->text('catatan_linguistik')->nullable()->after('catatan_pakar');
            }
        });
    }
    
    public function down()
    {
        Schema::table('usulan_terjemahans', function (Blueprint $table) {
            $table->dropColumn(['batas_waktu_diskusi', 'catatan_linguistik']);
        });
    }
}