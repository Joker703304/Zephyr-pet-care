<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('antrian', function (Blueprint $table) {
            $table->id(); // ID untuk antrian
            $table->unsignedBigInteger('konsultasi_id');  // Foreign key ke tabel konsultasi
            $table->string('no_antrian'); // Nomor antrian
            $table->enum('status', ['Menunggu', 'Dipanggil', 'Selesai'])->default('Menunggu'); // Status antrian
            $table->timestamps();

            // Menambahkan foreign key ke tabel konsultasi
            $table->foreign('konsultasi_id')->references('id_konsultasi')->on('konsultasi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('antrian');
    }
};

