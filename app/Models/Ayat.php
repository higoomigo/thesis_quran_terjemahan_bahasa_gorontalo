<?php
// app/Models/Ayat.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ayat extends Model
{
    protected $table = 'ayats';
    
    protected $fillable = [
        'teks_gorontalo' // Hanya ini yang boleh diubah
    ];
    
    protected $guarded = [
        'id',
        'no_surah',
        'nomorAyat',
        'Arab',
        'teksIndo',
        'created_at',
        'updated_at'
    ];
    
    protected $casts = [
        'no_surah' => 'integer',
        'nomorAyat' => 'integer',
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
    
    // Accessor untuk nomor ayat yang diformat
    public function getNomorAyatFormattedAttribute(): string
    {
        return "{$this->no_surah}:{$this->nomorAyat}";
    }

    public function ayatAudios()
    {
        return $this->hasMany(AyatAudio::class, 'ayat_id');
    }
}