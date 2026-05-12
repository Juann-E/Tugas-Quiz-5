<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('simpanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('kode_simpanan')->unique(); // contoh: SMP-0001
            $table->enum('jenis_simpanan', ['pokok', 'wajib', 'sukarela']);
            $table->decimal('jumlah', 15, 2);
            $table->date('tanggal_simpan');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('simpanan');
    }
};