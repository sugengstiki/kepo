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
        Schema::create('master_poin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_kegiatan_id')->constrained('jenis_kegiatans')->onDelete('cascade');
            $table->foreignId('peran_id')->constrained('peran')->onDelete('cascade');
            $table->foreignId('tingkat_id')->constrained('tingkat')->onDelete('cascade');
            $table->unsignedInteger('poin');
            $table->timestamps();

            $table->unique(['jenis_kegiatan_id', 'peran_id', 'tingkat_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_poin');
    }
};
