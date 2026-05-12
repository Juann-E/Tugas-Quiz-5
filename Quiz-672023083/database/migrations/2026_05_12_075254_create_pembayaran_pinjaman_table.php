<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran_pinjaman', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('pinjaman_id');

            $table->bigInteger('nominal_bayar');

            $table->timestamps();

            $table->foreign('pinjaman_id')
                  ->references('id')
                  ->on('pinjamans')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran_pinjaman');
    }
};