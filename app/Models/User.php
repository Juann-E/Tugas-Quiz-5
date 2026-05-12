<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name_panjang',
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // ── Relasi ──────────────────────────────────────

    public function simpanan()
    {
        return $this->hasMany(simpanan::class);
    }

    public function tabungan()
    {
        return $this->hasMany(tabungan::class);
    }

    public function pinjaman()
    {
        return $this->hasMany(pinjaman::class);
    }

    public function bayarPinjaman()
    {
        return $this->hasMany(bayar_pinjaman::class);
    }
}