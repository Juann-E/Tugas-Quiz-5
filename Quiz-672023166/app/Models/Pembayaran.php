<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'pinjaman_id',
        'jumlah_bayar'
    ];
}