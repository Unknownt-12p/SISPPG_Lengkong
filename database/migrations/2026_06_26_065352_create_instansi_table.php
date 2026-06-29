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
        Schema::create('instansi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_instansi')->unique();
            $table->string('nama_instansi');
            $table->enum('jenis_instansi', ['TK', 'SD', 'Posyandu', 'Puskesmas']);
            $table->text('alamat');
            $table->string('penanggung_jawab');
            $table->string('telepon');
            $table->string('email')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instansi');
    }
};
