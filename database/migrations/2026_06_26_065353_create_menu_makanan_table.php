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
        Schema::create('menu_makanan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_menu')->unique();
            $table->string('nama_menu');
            $table->enum('kategori_menu', ['Anak TK', 'Anak SD', 'Balita', 'Ibu Hamil', 'Ibu Menyusui']);
            $table->integer('kalori');
            $table->integer('protein');
            $table->integer('karbohidrat');
            $table->integer('lemak');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_makanan');
    }
};
