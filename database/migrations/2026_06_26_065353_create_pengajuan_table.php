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
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pengajuan')->unique();
            $table->foreignId('instansi_id')->constrained('instansi')->onDelete('cascade');
            $table->enum('kategori_penerima', ['Anak TK', 'Anak SD', 'Balita', 'Ibu Hamil', 'Ibu Menyusui']);
            $table->integer('jumlah_penerima');
            $table->integer('jumlah_porsi');
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_distribusi');
            $table->enum('status', ['Menunggu', 'Disetujui', 'Ditolak'])->default('Menunggu');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};
