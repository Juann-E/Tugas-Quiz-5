<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    protected $table = 'pinjaman';

    protected $fillable = [
        'user_id',
        'jumlah_pinjaman',
        'sisa_pinjaman',
        'status',
        'tanggal_pinjam',
    ];

    protected $casts = [
        'jumlah_pinjaman' => 'decimal:2',
        'sisa_pinjaman' => 'decimal:2',
        'tanggal_pinjam' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(PembayaranPinjaman::class);
    }
}
