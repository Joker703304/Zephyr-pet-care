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
            // Drop kolom status
            $table->dropColumn('status');
        });

        Schema::table('konsultasi', function (Blueprint $table) {
            // Tambahkan kolom status kembali dengan ENUM baru
            $table->enum('status', ['Menunggu', 'Sedang Perawatan', 'Pembuatan Obat', 'Selesai', 'Dibatalkan', 'Diterima', 'Pembayaran'])
                  ->default('Menunggu')
                  ->after('layanan_id'); // Sesuaikan posisi kolom sesuai kebutuhan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konsultasi', function (Blueprint $table) {
            // Drop kolom status
            $table->dropColumn('status');
        });

        Schema::table('konsultasi', function (Blueprint $table) {
            // Tambahkan kembali kolom status dengan ENUM lama
            $table->enum('status', ['Menunggu', 'Sedang Perawatan', 'Pembuatan Obat', 'Selesai', 'Dibatalkan', 'Diterima'])
                  ->default('Menunggu')
                  ->after('layanan_id');
        });
    }
};
