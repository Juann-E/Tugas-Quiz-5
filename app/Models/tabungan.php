<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tabungan extends Model
{
    protected $table = 'tabungan';

    protected $fillable = [
        'user_id',
        'no_rekening',
        'saldo',
        'status',
    ];

    protected $casts = [
        'saldo' => 'decimal:2',
    ];

    /**
     * Get the user that owns the tabungan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all mutasi for this tabungan.
     */
    public function mutasi()
    {
        return $this->hasMany(\App\Models\MutasiTabungan::class);
    }
}
