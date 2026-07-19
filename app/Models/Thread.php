<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = ['user_id', 'category_id', 'title', 'slug', 'body', 'views'];

    // Relasi: Thread dimiliki oleh 1 User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Thread masuk ke 1 Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: Thread punya banyak Balasan
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}