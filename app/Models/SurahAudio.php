<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurahAudio extends Model
{
    protected $table = 'surah_audios';
    protected $fillable = [
        'surah_id', 
        'langgam_id', 
        'pelantun_id', 
        'jenis_audio', 
        'file_path'
    ];

    public function surah(): BelongsTo
    {
        return $this->belongsTo(Surah::class, 'surah_id');
    }

    public function langgam(): BelongsTo
    {
        return $this->belongsTo(Langgam::class, 'langgam_id');
    }

    public function pelantun(): BelongsTo
    {
        return $this->belongsTo(Pelantun::class, 'pelantun_id');
    }
}