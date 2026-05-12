<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // Ini biar kolom-kolomnya boleh diisi otomatis
    protected $fillable = [
        'user_id', 
        'type', 
        'amount', 
        'description'
    ];

    // Relasi balik ke User (Opsional tapi bagus buat jaga-jaga)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}