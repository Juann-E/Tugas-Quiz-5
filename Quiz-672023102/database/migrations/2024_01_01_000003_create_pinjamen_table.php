<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pinjamen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained()->onDelete('cascade');
            $table->decimal('jumlah', 15, 2);
            $table->decimal('sisa', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->enum('status', ['aktif', 'lunas', 'belum lunas'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pinjamen');
    }
};