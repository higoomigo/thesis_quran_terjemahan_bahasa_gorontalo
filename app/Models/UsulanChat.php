<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsulanChat extends Model
{
    protected $table = 'usulan_chats';
    
    protected $fillable = [
        'usulan_id',
        'user_id',
        'pesan',
        'is_system_message'
    ];
    
    protected $casts = [
        'is_system_message' => 'boolean',
        'created_at' => 'datetime'
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