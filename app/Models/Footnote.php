<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Footnote extends Model
{
    protected $fillable = [
        'ayat_id',
        'nomor',
        'bahasa',
        'isi',
    ];

    public function ayat(): BelongsTo
    {
        return $this->belongsTo(Ayat::class, 'ayat_id');
    }
}