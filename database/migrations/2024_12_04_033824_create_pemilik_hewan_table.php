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
        Schema::create('pemilik_hewan', function (Blueprint $table) {
            $table->id('id_pemilik');
            $table->string('nama');
            $table->string('email');
            $table->enum('jenkel', ['pria', 'wanita']);
            $table->string('alamat');
            $table->string('no_tlp');
            $table->timestamps();

            $table->foreign('email')->references('email')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemilik_hewan');
    }
};
