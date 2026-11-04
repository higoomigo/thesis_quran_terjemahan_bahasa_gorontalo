<?php
// app/Models/Ayat.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ayat extends Model
{
    protected $table = 'ayats';
    
    protected $fillable = [
        'no_surah',
        'nomorAyat',
        'juz',
        'Arab',
        'teksIndo',
        'teks_gorontalo',
    ];

    protected $casts = [
        'no_surah'   => 'integer',
        'nomorAyat'  => 'integer',
    ];
    
    // Relasi ke usulan terjemahan
    public function usulan(): HasMany
    {
        return $this->hasMany(Usulan::class, 'ayat_id');
    }
    
    // Relasi ke surah
    public function surah()
    {
        return $this->belongsTo(Surah::class, 'no_surah', 'no_surah');
    }

    public function audioArabs()
    {
        return $this->hasMany(AudioArab::class);
    }

    public function audioGorontalos()
    {
        return $this->hasMany(AudioGorontalo::class);
    }

    // Accessor untuk nomor ayat yang diformat
    public function getNomorAyatFormattedAttribute(): string
    {
        return "{$this->no_surah}:{$this->nomorAyat}";
    }
}