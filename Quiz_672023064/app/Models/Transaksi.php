<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model {
    protected $table    = 'transaksi';
    protected $fillable = ['user_id', 'jenis', 'jumlah', 'keterangan'];
    protected $casts    = ['jumlah' => 'decimal:2'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}