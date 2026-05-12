<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bayar_pinjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pinjaman_id')->constrained('pinjaman')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('kode_bayar')->unique(); // contoh: BAY-0001
            $table->integer('ke_angsuran');          // angsuran ke-berapa
            $table->decimal('jumlah_bayar', 15, 2);
            $table->decimal('pokok_bayar', 15, 2);   // porsi pokok dari angsuran
            $table->decimal('bunga_bayar', 15, 2);   // porsi bunga dari angsuran
            $table->decimal('sisa_setelah_bayar', 15, 2);
            $table->date('tanggal_bayar');
            $table->enum('metode_bayar', ['tunai', 'transfer'])->default('tunai');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bayar_pinjaman');
    }
};