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
            $table->enum('status', ['Kosong', 'Sedang Melakukan Perawatan'])->default('Kosong')->after('spesialis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_dokter', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
