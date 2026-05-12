<?php
namespace App\Models;
 
use Illuminate\Foundation\Auth\User as Authenticatable;
 
class User extends Authenticatable
{
    protected $fillable = ['nama', 'username', 'password', 'saldo'];
 
    protected $hidden = ['password'];
 
    // Relasi ke loans
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
 
    // Relasi ke transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
