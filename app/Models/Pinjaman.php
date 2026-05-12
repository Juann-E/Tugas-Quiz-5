<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pinjaman extends Model
{
    protected $table = 'pinjaman';

    protected $fillable = ['user_id', 'jumlah', 'jumlah_dibayar', 'status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaksiPinjaman(): HasMany
    {
        return $this->hasMany(TransaksiPinjaman::class);
    }
}
