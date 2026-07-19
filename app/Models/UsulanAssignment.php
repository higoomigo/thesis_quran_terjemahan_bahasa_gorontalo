<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsulanAssignment extends Model
{
    // Mengizinkan create() dari controller
    protected $guarded = ['id'];

    // Relasi ke tabel User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel Usulan
    public function usulan(): BelongsTo
    {
        return $this->belongsTo(Usulan::class);
    }
}