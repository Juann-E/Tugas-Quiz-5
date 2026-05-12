<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
    protected $table = 'tabungan';

    protected $fillable = [
        'user_id',
        'jumlah',
        'tipe',
        'saldo_sebelum',
        'saldo_sesudah',
        'keterangan',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'saldo_sebelum' => 'decimal:2',
        'saldo_sesudah' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
