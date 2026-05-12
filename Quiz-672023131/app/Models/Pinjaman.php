<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    protected $table = 'pinjamans';

    protected $fillable = [
        'user_id',
        'jumlah',
        'sisa'
    ];
}