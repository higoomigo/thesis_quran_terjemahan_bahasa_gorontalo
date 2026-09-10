<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surah extends Model
{
    public function surahAudios()
    {
        return $this->hasMany(SurahAudio::class, 'surah_id');
    }

    public function ayats()
    {
        return $this->hasMany(Ayat::class, 'no_surah', 'no_surah');
    }
}
