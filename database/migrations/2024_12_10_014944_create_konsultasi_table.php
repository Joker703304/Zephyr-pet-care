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
            $table->unsignedBigInteger('dokter_id');
            $table->unsignedBigInteger('id_hewan');
            $table->string('keluhan');
            $table->date('tanggal_konsultasi');
            $table->enum('status', ['Menunggu', 'Sedang Diproses', 'Selesai', 'Dibatalkan'])->default('Menunggu');
            $table->timestamps();

            $table->foreign('dokter_id')->references('id')->on('tbl_dokter')->onDelete('cascade');
            $table->foreign('id_hewan')->references('id_hewan')->on('hewan')->onDelete('cascade');
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
