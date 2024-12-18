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
        // Schema::create('diagnosis', function (Blueprint $table) {
        //     $table->id('id_diagnosis');
        //     $table->unsignedBigInteger('id_konsultasi'); // Reference to the consultation
        //     $table->unsignedBigInteger('layanan_id'); // Reference to the service provided
        //     $table->text('diagnosis'); // Diagnosis description
        //     $table->timestamps();
    
        //     // Foreign key relations
        //     $table->foreign('id_konsultasi')->references('id_konsultasi')->on('konsultasi')->onDelete('cascade');
        //     $table->foreign('layanan_id')->references('id_layanan')->on('layanan')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('diagnosis');
    }
};
