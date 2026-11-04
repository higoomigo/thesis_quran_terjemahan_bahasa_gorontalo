<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AudioArab extends Model
{
    protected $table = 'audio_arabs';
    
    protected $guarded = ['id'];

    // Relasi ke tabel ayat
    public function ayat(): BelongsTo
    {
        return $this->belongsTo(Ayat::class);
    }

    // Relasi ke pelantun (Qari)
    public function pelantun(): BelongsTo
    {
        return $this->belongsTo(Pelantun::class);
    }

    // Relasi ke langgam (Bayati, Nahawand, dll)
    public function langgam(): BelongsTo
    {
        return $this->belongsTo(Langgam::class);
    }
}