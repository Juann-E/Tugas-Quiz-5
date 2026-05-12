<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'tanggal', 'total_pinjaman', 'sisa_pinjaman', 'status'])]
class Pinjaman extends Model {
    protected $table = 'pinjamans';
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}