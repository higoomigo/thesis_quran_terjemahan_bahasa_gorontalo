<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsulanVote extends Model
{
    protected $table = 'usulan_votes';
    
    protected $fillable = [
        'usulan_id',
        'user_id',
        'keputusan'
    ];
    
    protected $casts = [
        'keputusan' => 'string'
    ];
    
    public function usulan(): BelongsTo
    {
        return $this->belongsTo(Usulan::class);
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}