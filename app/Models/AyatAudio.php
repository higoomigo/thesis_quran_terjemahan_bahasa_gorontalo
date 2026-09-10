<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AyatAudio extends Model
{
    protected $table = 'ayat_audios';
    protected $fillable = [
        'ayat_id', 
        'langgam_id', 
        'qari_id', 
        'pembaca_gorontalo_id', 
        'file_path_arab', 
        'file_path_gorontalo'
    ];

    public function ayat(): BelongsTo
    {
        return $this->belongsTo(Ayat::class, 'ayat_id');
    }

    public function langgam(): BelongsTo
    {
        return $this->belongsTo(Langgam::class, 'langgam_id');
    }

    // Mengambil data Qari (Arab) dari tabel pelantuns
    public function qari(): BelongsTo
    {
        return $this->belongsTo(Pelantun::class, 'qari_id');
    }

    // Mengambil data Pembaca Gorontalo dari tabel pelantuns
    public function pembacaGorontalo(): BelongsTo
    {
        return $this->belongsTo(Pelantun::class, 'pembaca_gorontalo_id');
    }
}