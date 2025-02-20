<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['email', 'email_verified_at']); // Hapus kolom yang tidak diperlukan
            $table->string('phone')->unique()->nullable()->after('name'); // Tambah kolom nomor HP
            $table->string('email')->unique()->nullable()->after('phone');
            $table->timestamp('phone_verified_at')->nullable()->after('email'); // Tambah kolom verifikasi OTP
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email')->unique()->nullable();
            $table->dropColumn('phone');
            $table->dropColumn('phone_verified_at');
        });
    }
};