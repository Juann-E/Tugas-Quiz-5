<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tabungan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('no_rekening')->unique(); // contoh: REK-0001
            $table->decimal('saldo', 15, 2)->default(0);
            $table->enum('status', ['aktif', 'ditutup'])->default('aktif');
            $table->timestamps();
        });

        // Tabel riwayat mutasi tabungan
        Schema::create('mutasi_tabungan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tabungan_id')->constrained('tabungan')->onDelete('cascade');
            $table->enum('jenis', ['setor', 'tarik']);
            $table->decimal('jumlah', 15, 2);
            $table->decimal('saldo_sebelum', 15, 2);
            $table->decimal('saldo_sesudah', 15, 2);
            $table->date('tanggal_transaksi');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mutasi_tabungan');
        Schema::dropIfExists('tabungan');
    }
};