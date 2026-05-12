<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;

    protected $fillable = ['nama_lengkap', 'username', 'password', 'saldo'];
    protected $hidden   = ['password', 'remember_token'];
    protected $casts    = ['saldo' => 'decimal:2'];

    public function pinjaman() {
        return $this->hasMany(Pinjaman::class);
    }
    public function pinjamanAktif() {
        return $this->hasMany(Pinjaman::class)->where('status', 'aktif');
    }
    public function transaksi() {
        return $this->hasMany(Transaksi::class);
    }
}