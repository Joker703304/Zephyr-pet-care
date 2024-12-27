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
        Schema::table('tbl_dokter', function (Blueprint $table) {
            $table->dropColumn(['hari', 'jam_mulai', 'jam_selesai']); // Hapus kolom lama
            $table->enum('jenkel', ['pria', 'wanita'])->after('no_telepon'); // Tambahkan kolom jenkel
            $table->string('alamat')->after('jenkel'); // Tambahkan kolom alamat
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_dokter', function (Blueprint $table) {
            $table->json('hari')->nullable(); // Kembalikan kolom hari
            $table->time('jam_mulai')->nullable(); // Kembalikan kolom jam_mulai
            $table->time('jam_selesai')->nullable(); // Kembalikan kolom jam_selesai
            $table->dropColumn(['jenkel', 'alamat']); // Hapus kolom jenkel dan alamat
        });
    }
};
