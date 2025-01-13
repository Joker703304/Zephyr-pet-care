<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dokter_jadwal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_dokter');
            $table->date('tanggal');
            $table->enum('status', ['Praktik', 'Tidak Praktik']);
            $table->integer('maksimal_konsultasi')->nullable();
            $table->timestamps();

            $table->foreign('id_dokter')->references('id')->on('tbl_dokter')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokter_jadwal');
    }
};
