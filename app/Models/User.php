<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'saldo_tabungan'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'saldo_tabungan' => 'decimal:2',
        ];
    }

    public function pinjamans(): HasMany
    {
        return $this->hasMany(Pinjaman::class);
    }

    public function transaksiTabungans(): HasMany
    {
        return $this->hasMany(TransaksiTabungan::class);
    }

    public function transaksiPinjaman(): HasMany
    {
        return $this->hasMany(TransaksiPinjaman::class);
    }
}
