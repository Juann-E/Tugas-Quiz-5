<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $table = 'loans';

    protected $fillable = [
        'user_id',
        'amount',
        'remaining',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}