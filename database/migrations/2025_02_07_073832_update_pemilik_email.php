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
        Schema::table('pemilik_hewan', function (Blueprint $table) {
            $table->dropForeign(['email']);
            $table->dropColumn('email');
            $table->dropColumn('no_tlp');
        });

        Schema::table('tbl_dokter', function (Blueprint $table) {
            $table->dropColumn('no_telepon');
        });

        Schema::table('apotekers', function (Blueprint $table) {
            $table->dropColumn('no_telepon');
        });

        Schema::table('kasir', function (Blueprint $table) {
            $table->dropColumn('no_telepon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('pemilik_hewan', function (Blueprint $table) {
        // Hanya hapus kolom yang ada
        if (Schema::hasColumn('pemilik_hewan', 'email')) {
            $table->dropForeign(['email']);
            $table->dropColumn('email');
        }
        if (Schema::hasColumn('pemilik_hewan', 'no_tlp')) {
            $table->dropColumn('no_tlp');
        }
    });

    Schema::table('tbl_dokter', function (Blueprint $table) {
        if (Schema::hasColumn('tbl_dokter', 'no_telepon')) {
            $table->dropColumn('no_telepon');
        }
    });

    Schema::table('apotekers', function (Blueprint $table) {
        if (Schema::hasColumn('apotekers', 'no_telepon')) {
            $table->dropColumn('no_telepon');
        }
    });

    Schema::table('kasir', function (Blueprint $table) {
        if (Schema::hasColumn('kasir', 'no_telepon')) {
            $table->dropColumn('no_telepon');
        }
    });
}

};
