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
            $table->string('kode_pinjaman')->unique(); // contoh: PIN-0001
            $table->decimal('jumlah_pinjaman', 15, 2);
            $table->decimal('bunga_persen', 5, 2)->default(1.5); // % per bulan
            $table->integer('tenor_bulan'); // lama cicilan dalam bulan
            $table->decimal('angsuran_per_bulan', 15, 2); // dihitung otomatis
            $table->decimal('total_bayar', 15, 2);          // pokok + total bunga
            $table->decimal('sisa_pinjaman', 15, 2);        // sisa yang belum dibayar
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_disetujui')->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'lunas'])->default('menunggu');
            $table->text('tujuan_pinjaman')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pinjaman');
    }
};