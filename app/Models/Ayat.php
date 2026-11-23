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

    public function footnotes()
    {
        return $this->hasMany(Footnote::class, 'ayat_id')->orderBy('nomor');
    }

    // Accessor untuk nomor ayat yang diformat
    public function getNomorAyatFormattedAttribute(): string
    {
        return "{$this->no_surah}:{$this->nomorAyat}";
    }

    public function getFormattedTeksIndoAttribute(): string
    {
        $teks = e($this->teksIndo ?? '');
        $footnotes = $this->footnotes->where('bahasa', 'indonesia')->keyBy('nomor');

        // Rapikan teks terjemahan untuk ditampilkan di dalam modal
        // $teksBersih = preg_replace('/\s*\[(\d+)\]\s*/', ' ($1) ', $this->teksIndo ?? '');
        // $teksBersih = trim(preg_replace('/\s+/', ' ', $teksBersih));
        // $terjemahanAman = e($teksBersih);

        return preg_replace_callback('/\[(\d+)\]/', function ($matches) use ($footnotes, $teks) {
            $nomor = (int) $matches[1];
            $fn = $footnotes->get($nomor);

            if (!$fn) {
                return '';
            }

            $isiAman = e($fn->isi);

            return '<button type="button" onclick="openFootnoteModal(this)" '
                . 'data-nomor="' . $nomor . '" '
                . 'data-ayat="' . e($this->nomorAyat) . '" '
                . 'data-terjemahan="' . $teks . '" '
                . 'data-isi="' . $isiAman . '" '
                . 'class="inline-flex items-center justify-center min-w-[24px] h-[24px] px-1.5 mx-1 text-xs font-bold text-emerald-700 bg-emerald-100 hover:bg-emerald-600 hover:text-white rounded-lg align-super transition-colors cursor-pointer shadow-sm">'
                . $nomor
                . '</button>';
        }, $teks);
    }
}
