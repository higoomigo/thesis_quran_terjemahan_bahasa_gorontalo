<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AudioGorontalo extends Model
{
    protected $table = 'audio_gorontalos';
    
    protected $guarded = ['id'];

    // Relasi ke tabel ayat
    public function ayat(): BelongsTo
    {
        return $this->belongsTo(Ayat::class);
    }

    // Relasi ke pembaca Gorontalo (mengarah ke tabel pelantuns)
    public function pembacaGorontalo(): BelongsTo
    {
        return $this->belongsTo(Pelantun::class, 'pembaca_gorontalo_id');
    }
}