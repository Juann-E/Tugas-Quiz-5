<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranPinjaman extends Model
{
    protected $table = 'pembayaran_pinjaman';

    protected $fillable = [
        'pinjaman_id',
        'nominal_bayar'
    ];

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class);
    }
}