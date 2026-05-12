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
        Schema::create('pinjamans', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                  ->constrained('pinjamans')
                  ->onDelete('cascade');

            $table->integer('jumlah_pinjaman');

            $table->integer('sisa_pinjaman');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjamans');
    }
};