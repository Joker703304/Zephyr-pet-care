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
        Schema::create('konsultasi_layanan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_konsultasi');
            $table->unsignedBigInteger('id_layanan');
            $table->timestamps();
    
            // Menambahkan foreign key constraints
            $table->foreign('id_konsultasi')->references('id_konsultasi')->on('konsultasi')->onDelete('cascade');
            $table->foreign('id_layanan')->references('id_layanan')->on('layanan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultasi_layanan');
    }
};
