<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Anggota extends Model
{
    protected $fillable = ['nama', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tabungans(): HasMany
    {
        return $this->hasMany(Tabungan::class);
    }

    public function pinjamans(): HasMany
    {
        return $this->hasMany(Pinjaman::class);
    }

    public function getTotalTabunganAttribute()
    {
        return $this->tabungans()->sum('jumlah');
    }

    public function getTotalPinjamanAttribute()
    {
        return $this->pinjamans()->where('status', 'aktif')->sum('sisa');
    }
}