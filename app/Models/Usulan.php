<?php
// app/Models/UsulanTerjemahan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usulan extends Model
{
    protected $table = 'usulan_terjemahans';

    protected $fillable = [
        'ayat_id',
        'nama_pengusul',
        'no_hp',
        'usulan_teks',
        'status',
        'catatan_pakar',
        'catatan_linguistik',
        'batas_waktu_diskusi',
        'teks_rekomendasi',
        'alasan_revisi',
        'validated_at'
    ];

    protected $casts = [
        'status' => 'string',
        'created_at' => 'datetime',
        'batas_waktu_diskusi' => 'datetime',
        'validated_at' => 'datetime',
    ];

    public function assignments()
    {
        return $this->hasMany(UsulanAssignment::class, 'usulan_id', 'id');
    }

    // Relasi ke ayat
    public function ayat(): BelongsTo
    {
        return $this->belongsTo(Ayat::class, 'ayat_id');
    }

    // Helper untuk badge status
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'bg-yellow-100 text-yellow-800',
            'diterima' => 'bg-green-100 text-green-800',
            'ditolak' => 'bg-red-100 text-red-800',
            'diarsipkan' => 'bg-orange-100 text-orange-800', // <-- Tambahin ini
            default => 'bg-gray-100 text-gray-800',
        };
    }

    // Helper untuk teks status
    public function getStatusTextAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => '⏳ Menunggu Review',
            'diterima' => '✓ Diterima',
            'ditolak' => '✗ Ditolak',
            'diarsipkan' => '📦 Diarsipkan', // <-- Tambahin ini
            default => $this->status,
        };
    }

    // Sensor nama untuk privasi
    public function getNamaPengusulSensorAttribute(): string
    {
        $nama = $this->nama_pengusul;
        $panjang = strlen($nama);

        if ($panjang <= 3) {
            return substr($nama, 0, 1) . str_repeat('*', $panjang - 1);
        }

        return substr($nama, 0, 2) . str_repeat('*', $panjang - 2);
    }

    public function chats(): HasMany
    {
        return $this->hasMany(UsulanChat::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(UsulanVote::class);
    }

    // public function assignments(): HasMany
    // {
    //     return $this->hasMany(UsulanAssignment::class);
    // }
}
