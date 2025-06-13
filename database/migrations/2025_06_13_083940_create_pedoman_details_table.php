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
        Schema::create('pedoman_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedoman_id')->constrained()->onDelete('cascade');
            $table->string('peran');
            $table->string('tingkat');
            $table->integer('poin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedoman_details');
    }
};
