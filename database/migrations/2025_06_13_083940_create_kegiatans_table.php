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
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained()->onDelete('cascade');
            $table->foreignId('pedoman_id')->constrained()->onDelete('cascade');
            $table->string('nama_kegiatan');
            $table->string('berkas_pendukung');
            $table->integer('poin');
            $table->enum('status_validasi', ['pending', 'valid', 'tidak valid'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatans');
    }
};
