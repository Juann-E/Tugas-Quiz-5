<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
    protected $table = 'tabungans';

    protected $fillable = [
        'user_id',
        'jenis',
        'nominal'
    ];
}