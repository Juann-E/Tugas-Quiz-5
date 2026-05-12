<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pinjamans', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');

            $table->bigInteger('nominal');
            $table->bigInteger('sisa_pinjaman');

            $table->enum('status', ['belum_lunas', 'lunas'])
                  ->default('belum_lunas');

            $table->date('tanggal_pembayaran');

            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pinjamans');
    }
};