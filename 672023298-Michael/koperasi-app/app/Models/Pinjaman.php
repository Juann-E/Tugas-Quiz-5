<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    protected $fillable = [
        'user_id',
        'jumlah',
        'sisa_pinjaman',
        'status',
    ];
}
