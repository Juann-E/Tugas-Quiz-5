<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pinjamanss extends Model
{
    protected $table = 'pinjamanss';

    protected $fillable = ['user_id', 'total_pinjaman', 'sisa_pinjaman'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}