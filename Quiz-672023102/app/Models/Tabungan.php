<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tabungan extends Model
{
    protected $fillable = ['anggota_id', 'jumlah', 'keterangan'];

    protected $casts = [
        'jumlah' => 'decimal:2',
    ];

    public function anggota(): BelongsTo
    {
        return $this->belongsTo(Anggota::class);
    }
}