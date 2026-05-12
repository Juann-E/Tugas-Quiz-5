<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
    protected $table = 'tabungan';

    protected $fillable = [
        'user_id', 'jenis', 'jumlah', 'saldo_sebelum', 'saldo_sesudah'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
