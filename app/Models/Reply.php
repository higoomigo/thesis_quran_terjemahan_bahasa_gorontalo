<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ['user_id', 'thread_id', 'body'];

    // Relasi: Balasan ini ditulis oleh 1 User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Balasan ini nempel di 1 Thread
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}
