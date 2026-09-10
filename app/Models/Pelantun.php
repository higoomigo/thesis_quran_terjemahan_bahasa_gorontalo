<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelantun extends Model
{
    protected $table = 'pelantuns'; // Sesuai nama tabel
    protected $fillable = ['nama', 'peran', 'foto', 'deskripsi'];

    // Relasi kalau dia jadi Qari (pembaca Arab) di potongan ayat
    public function ayatAudiosSebagaiQari(): HasMany
    {
        return $this->hasMany(AyatAudio::class, 'qari_id');
    }

    // Relasi kalau dia jadi Pembaca Terjemahan Gorontalo di potongan ayat
    public function ayatAudiosSebagaiPembaca(): HasMany
    {
        return $this->hasMany(AyatAudio::class, 'pembaca_gorontalo_id');
    }

    // Relasi ke audio full surah
    public function surahAudios(): HasMany
    {
        return $this->hasMany(SurahAudio::class, 'pelantun_id');
    }

    protected $guarded = ['id']; // atau $table = 'pelantun'; jika nama tabelnya singular

    // Relasi Many-to-Many ke Langgam
    public function langgams()
    {
        return $this->belongsToMany(Langgam::class, 'langgam_pelantun', 'pelantun_id', 'langgam_id')->withTimestamps();
    }
}