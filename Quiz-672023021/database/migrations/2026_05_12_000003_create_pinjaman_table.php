<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pinjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('jumlah_pinjaman', 15, 2);   // Total pinjaman awal
            $table->decimal('sisa_pinjaman', 15, 2);     // Sisa yang belum dibayar
            $table->date('tanggal_pinjam');
            $table->enum('status', ['active', 'lunas'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pinjaman');
    }
};
