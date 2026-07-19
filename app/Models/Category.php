<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    // Relasi: Kategori punya banyak Thread
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}