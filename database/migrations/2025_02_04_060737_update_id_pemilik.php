<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('hewan', function (Blueprint $table) {
            // Menjadikan kolom 'id_pemilik' nullable
            $table->unsignedBigInteger('id_pemilik')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('hewan', function (Blueprint $table) {
            // Mengembalikan kolom 'id_pemilik' menjadi tidak nullable
            $table->unsignedBigInteger('id_pemilik')->nullable(false)->change();
        });
    }
};
