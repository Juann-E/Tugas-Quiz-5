<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/bayar_pinjaman.php
class bayar_pinjaman extends Model
{
    protected $table = 'bayar_pinjaman';

    protected $fillable = [
        'pinjaman_id', 'user_id', 'kode_bayar', 'ke_angsuran',
        'jumlah_bayar', 'pokok_bayar', 'bunga_bayar',
        'sisa_setelah_bayar', 'tanggal_bayar', 'metode_bayar', 'keterangan',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
    ];

    public function pinjaman()
    {
        return $this->belongsTo(pinjaman::class, 'pinjaman_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}