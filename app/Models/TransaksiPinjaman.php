<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiPinjaman extends Model
{
    protected $table = 'transaksi_pinjaman';

    protected $fillable = ['user_id', 'pinjaman_id', 'jumlah'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pinjaman(): BelongsTo
    {
        return $this->belongsTo(Pinjaman::class);
    }
}
