<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal.
     * username ditambahkan untuk login, balance untuk menyimpan saldo.
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'balance',
    ];

    /**
     * Atribut yang harus disembunyikan untuk serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Method casts untuk memastikan password di-hash secara otomatis (Laravel 11+).
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi: Satu user bisa memiliki banyak pinjaman.
     * Memungkinkan kita memanggil Auth::user()->loans.
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}