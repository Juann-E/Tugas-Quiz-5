<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pinjaman extends Model
{
    protected $table = 'pinjaman';
    protected $fillable = [
        'user_id',
        'kode_pinjaman',
        'jumlah_pinjaman',
        'bunga_persen',
        'tenor_bulan',
        'angsuran_per_bulan',
        'total_bayar',
        'sisa_pinjaman',
        'tanggal_pengajuan',
        'tanggal_disetujui',
        'status',
        'tujuan_pinjaman',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_disetujui' => 'date',
    ];

    /**
     * Get the user that owns the pinjaman.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all pembayaran for this pinjaman.
     */
    public function pembayaran()
    {
        return $this->hasMany(bayar_pinjaman::class);
    }
}
