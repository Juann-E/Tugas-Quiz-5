<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // Sesuaikan fillable dengan field yang kita buat
    protected $fillable = ['name', 'username', 'password', 'saldo'];

    // Relasi: User memiliki banyak pinjaman
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}