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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['baa','bam','dosen', 'mahasiswa'])->default('mahasiswa')->after('password');
            $table->foreignId('angkatan_id')->nullable()->constrained('angkatan')->onDelete('set null')->after('role');            
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['angkatan_id']);
            $table->dropColumn(['role', 'angkatan_id']);
        });
    }
};
