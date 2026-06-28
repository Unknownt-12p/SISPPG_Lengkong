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
        Schema::create('penyaluran', function (Blueprint $table) {
            $table->id();
            $table->string('kode_penyaluran')->unique();
            $table->foreignId('pengajuan_id')->constrained('pengajuan')->onDelete('cascade');
            $table->foreignId('menu_id')->constrained('menu_makanan')->onDelete('cascade');
            $table->date('tanggal_penyaluran');
            $table->integer('jumlah_disalurkan');
            $table->enum('status_pengiriman', ['Diproses', 'Dikirim', 'Selesai'])->default('Diproses');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyaluran');
    }
};
