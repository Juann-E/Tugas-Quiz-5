<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pinjaman extends Model
{
    protected $fillable = ['anggota_id', 'jumlah', 'sisa', 'keterangan', 'status'];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'sisa' => 'decimal:2',
        'status' => 'string',
    ];

    public function anggota(): BelongsTo
    {
        return $this->belongsTo(Anggota::class);
    }

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }
}