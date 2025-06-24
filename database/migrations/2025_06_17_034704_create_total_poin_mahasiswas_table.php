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
        Schema::create('total_poin_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained()->unique();
            $table->integer('total_poin')->default(0);
            $table->timestamp('terakhir_diperbarui')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('total_poin_mahasiswas');
    }
};
