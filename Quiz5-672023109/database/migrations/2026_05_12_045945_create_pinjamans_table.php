<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
    Schema::create('pinjamans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->date('tanggal'); // [cite: 29]
        $table->integer('total_pinjaman'); // [cite: 30]
        $table->integer('sisa_pinjaman'); // [cite: 31]
        $table->string('status')->default('Active'); // [cite: 32, 36]
        $table->timestamps();
    });
}

public function down(): void {
    Schema::dropIfExists('pinjamans');
}
};
