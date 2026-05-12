<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MutasiTabungan extends Model
{
    protected $table = 'mutasi_tabungan';

    protected $fillable = [
        'tabungan_id',
        'jenis',
        'jumlah',
        'saldo_sebelum',
        'saldo_sesudah',
        'tanggal_transaksi',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'date',
    ];

    /**
     * Get the tabungan that owns this mutasi.
     */
    public function tabungan()
    {
        return $this->belongsTo(tabungan::class);
    }
}
