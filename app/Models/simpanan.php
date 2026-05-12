<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class simpanan extends Model
{
    protected $table = 'simpanan';
    protected $fillable = [
        'user_id',
        'kode_simpanan',
        'jenis_simpanan',
        'jumlah',
        'tanggal_simpan',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_simpan' => 'date',
    ];

    /**
     * Get the user that owns the simpanan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
