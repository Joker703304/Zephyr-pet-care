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
        Schema::create('tbl_dokter', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('id_user');
            $table->string('spesialis', 50)->nullable(); // Spesialisasi dokter
            $table->string('no_telepon', 20)->unique(); // Nomor telepon
            $table->json('hari')->nullable(); // Ubah kolom hari menjadi json
            $table->time('jam_mulai')->nullable(); // Jam mulai kerja
            $table->time('jam_selesai')->nullable();// Jam selesai kerja
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps(); // Kolom created_at dan updated_at
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_dokter');
    }
};
