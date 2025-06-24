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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('nrp')->unique()->after('id'); // Menambahkan kolom NRP
            $table->string('nama')->after('nrp'); // Menambahkan kolom Nama
            $table->string('email')->after('nama');
            $table->integer('tahun_masuk')->after('email');
            $table->foreignId('program_studi_id')->constrained();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
