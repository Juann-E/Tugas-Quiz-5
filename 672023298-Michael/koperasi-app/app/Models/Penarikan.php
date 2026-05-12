<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penarikan extends Model
{
    protected $fillable = [
        'user_id',
        'jumlah',
    ];
}
