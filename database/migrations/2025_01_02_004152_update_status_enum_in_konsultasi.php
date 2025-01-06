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
        Schema::table('konsultasi', function (Blueprint $table) {
            
            DB::statement("ALTER TABLE konsultasi MODIFY COLUMN status ENUM('Menunggu', 'Sedang Perawatan', 'Pembuatan Obat', 'Selesai', 'Dibatalkan', 'Diterima') DEFAULT 'Menunggu'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konsultasi', function (Blueprint $table) {
            DB::statement("ALTER TABLE konsultasi MODIFY COLUMN status ENUM('Menunggu', 'Sedang Perawatan', 'Pembuatan Obat', 'Selesai', 'Dibatalkan') DEFAULT 'Menunggu'");
        });
    }
};