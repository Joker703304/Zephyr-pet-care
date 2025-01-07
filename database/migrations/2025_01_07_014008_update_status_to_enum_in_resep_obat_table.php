<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateStatusToEnumInResepObatTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update nilai status yang tidak valid sebelum mengubah tipe data
        DB::table('resep_obat')->whereNotIn('status', ['sedang di siapkan', 'siap'])
            ->update(['status' => 'sedang di siapkan']);

        Schema::table('resep_obat', function (Blueprint $table) {
            $table->enum('status', ['sedang di siapkan', 'siap'])
                  ->default('sedang di siapkan')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resep_obat', function (Blueprint $table) {
            $table->string('status')->default('sedang di siapkan')->change();
        });
    }
}
