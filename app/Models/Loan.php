<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'user_id', 
        'total_pinjaman', 
        'sisa_pinjaman', 
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}