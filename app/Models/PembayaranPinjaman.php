<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranPinjaman extends Model
{
    protected $table = 'pembayaran_pinjaman';

    protected $fillable = [
        'pinjaman_id',
        'user_id',
        'jumlah_bayar',
        'sisa_sebelum',
        'sisa_sesudah',
        'tanggal_bayar',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
        'jumlah_bayar'  => 'decimal:2',
        'sisa_sebelum'  => 'decimal:2',
        'sisa_sesudah'  => 'decimal:2',
    ];

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}