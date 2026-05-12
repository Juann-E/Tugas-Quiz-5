<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model {
    protected $fillable = ['user_id', 'total_pinjaman', 'sisa_pinjaman', 'status'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
