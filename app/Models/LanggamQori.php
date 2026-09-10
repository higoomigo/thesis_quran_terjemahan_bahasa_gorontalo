<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Langgam extends Model
{
    protected $guarded = ['id'];

    // Relasi Many-to-Many ke Pelantun (Qari)
    public function pelantuns()
    {
        // Parameter: (Model Tujuan, Nama Tabel Pivot, FK Model Ini, FK Model Tujuan)
        return $this->belongsToMany(Pelantun::class, 'langgam_pelantun', 'langgam_id', 'pelantun_id')->withTimestamps();
    }
}