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
        Schema::create('resep_obat', function (Blueprint $table) {
            $table->id('id_resep');
            $table->unsignedBigInteger('id_konsultasi'); // Konsultasi terkait
            $table->string('id_obat'); // Obat terkait
            $table->integer('jumlah'); // Jumlah obat yang diresepkan
            $table->text('keterangan')->nullable(); // Keterangan tambahan (opsional)
            $table->timestamps();
    
            // Foreign keys
            $table->foreign('id_konsultasi')->references('id_konsultasi')->on('konsultasi')->onDelete('cascade');
            $table->foreign('id_obat')->references('id_obat')->on('obat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resep_obat');
    }
};
