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
            $table->string('nama', 100); // Nama dokter
            $table->string('spesialis', 50)->nullable(); // Spesialisasi dokter
            $table->string('no_telepon', 20)->unique(); // Nomor telepon
            $table->string('hari', 20)->nullable();; // Hari kerja (Senin, Selasa, dst.)
            $table->time('jam_mulai')->nullable();; // Jam mulai kerja
            $table->time('jam_selesai')->nullable();; // Jam selesai kerja
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
