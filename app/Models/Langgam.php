<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Langgam extends Model
{
    protected $table = 'langgams';
    protected $fillable = ['nama', 'deskripsi'];

    public function ayatAudios(): HasMany
    {
        return $this->hasMany(AyatAudio::class, 'langgam_id');
    }

    public function surahAudios(): HasMany
    {
        return $this->hasMany(SurahAudio::class, 'langgam_id');
    }
    // Relasi Many-to-Many ke Pelantun (Qari)
    public function pelantuns()
    {
        // Parameter: (Model Tujuan, Nama Tabel Pivot, FK Model Ini, FK Model Tujuan)
        return $this->belongsToMany(Pelantun::class, 'langgam_pelantun', 'langgam_id', 'pelantun_id')->withTimestamps();
    }
}