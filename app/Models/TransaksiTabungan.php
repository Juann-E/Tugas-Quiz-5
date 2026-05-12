<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiTabungan extends Model
{
    protected $table = 'transaksi_tabungan';

    protected $fillable = ['user_id', 'tipe', 'jumlah'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
