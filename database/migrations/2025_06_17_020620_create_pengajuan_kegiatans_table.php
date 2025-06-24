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
        Schema::create('pengajuan_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->onDelete('cascade');
            $table->string('nama_kegiatan');
            $table->string('tanggal_kegiatan');
            $table->string('file_pendukung');

            $table->foreignId('master_poin_id')->constrained('master_poin');

            $table->enum('status', ['diajukan', 'disetujui', 'ditolak'])->default('diajukan');
            $table->unsignedInteger('poin_diterima');
            $table->text('catatan_validator')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_kegiatans');
    }
};
