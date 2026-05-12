<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    protected $fillable = ['nama_lengkap', 'username', 'password', 'saldo'];

    protected $hidden = ['password'];

    protected $casts = [
        'saldo' => 'decimal:2',
    ];

    public function pinjaman(): HasMany
    {
        return $this->hasMany(Pinjaman::class);
    }

    public function pinjamanAktif(): HasMany
    {
        return $this->hasMany(Pinjaman::class)->where('status', 'active');
    }

    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class);
    }
}
