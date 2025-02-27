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
        Schema::table('security', function (Blueprint $table) {
            $table->dropColumn('no_telepon');
        });

        // Schema::table('users', function (Blueprint $table) {
        //     $table->dropColumn(['email', 'email_verified_at']); // Hapus kolom yang tidak diperlukan
        // });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('security', function (Blueprint $table) {
            if (Schema::hasColumn('security', 'no_telepon')) {
                $table->dropColumn('no_telepon');
            }
        });
    }
};
