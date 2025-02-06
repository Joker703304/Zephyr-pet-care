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
        Schema::table('hewan', function (Blueprint $table) {
            $table->unsignedBigInteger('jenis_id')->nullable(); // Jika nullable, bisa kosongkan jenis hewan
            $table->foreign('jenis_id')->references('id')->on('jenis_hewan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hewan', function (Blueprint $table) {
            $table->dropForeign(['jenis_id']);
            $table->dropColumn('jenis_id');
        });
    }
};
