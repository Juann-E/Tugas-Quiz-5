<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;

    protected $table = 'pinjaman';
    protected $fillable = ['user_id', 'jumlah', 'sisa', 'status', 'tanggal'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}