<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Surah extends Model
{
    protected $table = 'surahs';

    protected $fillable = [
        'no_surah',
        'nama_latin',
        'jumlah_ayat',
        'arti',
    ];

    protected $casts = [
        'no_surah'    => 'integer',
        'jumlah_ayat' => 'integer',
    ];

    /**
     * Kolom yang tidak boleh diubah setelah record dibuat.
     * Cuma no_surah, nama_latin, jumlah_ayat, arti.
     * (Semua kolom sebenarnya immutable, tapi kalau nanti ada kolom lain
     *  yang boleh diubah, tinggal kecualikan dari list ini.)
     */
    protected static function booted()
    {
        static::updating(function ($surah) {
            if ($surah->isDirty(['no_surah', 'nama_latin', 'jumlah_ayat', 'arti'])) {
                throw new \Exception('Data surah tidak boleh diubah setelah dibuat.');
            }
        });
    }

    /**
     * Relasi ke ayat-ayat dalam surah ini.
     * Join berdasarkan kolom no_surah (bukan id),
     * karena di tabel ayats kolomnya no_surah.
     */
    public function ayats(): HasMany
    {
        return $this->hasMany(Ayat::class, 'no_surah', 'no_surah');
    }
}