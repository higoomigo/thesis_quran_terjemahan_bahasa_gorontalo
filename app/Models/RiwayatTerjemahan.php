<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatTerjemahan extends Model
{
    protected $guarded = ['id'];

    public function ayat(): BelongsTo
    {
        return $this->belongsTo(Ayat::class);
    }

    public function usulan(): BelongsTo
    {
        return $this->belongsTo(Usulan::class);
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id');
    }
}