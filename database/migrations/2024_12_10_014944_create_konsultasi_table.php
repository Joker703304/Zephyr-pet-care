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
        Schema::create('konsultasi', function (Blueprint $table) {
            $table->id('id_konsultasi');
            $table->string('no_antrian');
            $table->unsignedBigInteger('dokter_id')->nullable();
            $table->unsignedBigInteger('id_hewan');
            $table->string('keluhan');
            $table->date('tanggal_konsultasi');
            $table->text('diagnosis')->nullable();
            $table->unsignedBigInteger('layanan_id')->nullable(); // Reference to the service provided
            $table->enum('status', ['Menunggu', 'Sedang Diproses', 'Selesai', 'Dibatalkan', 'Diterima'])->default('Menunggu');
            $table->timestamps();

            $table->foreign('dokter_id')->references('id')->on('tbl_dokter')->onDelete('cascade');
            $table->foreign('id_hewan')->references('id_hewan')->on('hewan')->onDelete('cascade');
            $table->foreign('layanan_id')->references('id_layanan')->on('layanan')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultasi');
    }
};
