<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model {
    protected $fillable = ['nama_lengkap', 'username', 'password', 'saldo'];

    protected $hidden = ['password'];

    public function savings(): HasMany {
        return $this->hasMany(Saving::class);
    }

    public function loans(): HasMany {
        return $this->hasMany(Loan::class);
    }

    public function activeLoans(): HasMany {
        return $this->hasMany(Loan::class)->where('status', 'active');
    }
}
