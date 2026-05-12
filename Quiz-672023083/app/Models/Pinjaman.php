<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    protected $table = 'pinjamans';

    protected $fillable = [
        'user_id',
        'nominal',
        'sisa_pinjaman',
        'status',
        'tanggal_pembayaran'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}