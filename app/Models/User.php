<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = ['nama_lengkap', 'username', 'password', 'saldo'];
    protected $hidden = ['password'];

    public function pinjaman()
    {
        return $this->hasMany(Pinjaman::class);
    }

    public function pinjamanAktif()
    {
        return $this->pinjaman()->where('status', 'aktif');
    }
}