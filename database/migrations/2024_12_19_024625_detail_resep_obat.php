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
        Schema::create('detail_resep_obat', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('id_resep'); // ID Resep terkait
            $table->string('id_obat'); // ID Obat yang diresepkan
            $table->date('tanggal_resep')->nullable(); // Tanggal pembuatan resep
            $table->enum('status', ['diberikan', 'belum_diberikan'])->default('belum_diberikan'); // Status resep
            $table->timestamps();
        
            // Foreign keys
            $table->foreign('id_resep')->references('id_resep')->on('resep_obat')->onDelete('cascade');
            $table->foreign('id_obat')->references('id_obat')->on('obat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_resep_obat');
    }
};
