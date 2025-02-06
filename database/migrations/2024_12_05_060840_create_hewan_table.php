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
        Schema::create('hewan', function (Blueprint $table) {
            $table->id('id_hewan');
            $table->unsignedBigInteger('id_pemilik'); // Tipe data harus cocok dengan tabel pemilik_hewan
            $table->string('nama_hewan');
            $table->foreignId('jenis_id')->constrained('jenis_hewan')->onDelete('cascade');
            $table->enum('jenkel', ['jantan', 'betina']);
            $table->integer('umur')->nullable();
            $table->decimal('berat', 8, 2)->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        
            // Foreign key
            $table->foreign('id_pemilik')->references('id_pemilik')->on('pemilik_hewan')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hewan');
    }
};
