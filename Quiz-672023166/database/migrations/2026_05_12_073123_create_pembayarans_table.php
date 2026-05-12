<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('pinjaman_id');

            $table->foreign('pinjaman_id')
                  ->references('id')
                  ->on('pinjamans')
                  ->onDelete('cascade');

            $table->integer('jumlah_bayar');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};