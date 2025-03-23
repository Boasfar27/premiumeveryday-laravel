<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Periksa apakah kolom 'value' ada di tabel coupons
        if (!Schema::hasColumn('coupons', 'value')) {
            // Jika tidak ada, tambahkan kolom 'value'
            Schema::table('coupons', function (Blueprint $table) {
                $table->decimal('value', 10, 2)->after('discount')->nullable();
            });
            
            // Salin nilai dari kolom 'discount' ke kolom 'value'
            DB::statement('UPDATE coupons SET value = discount');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Jika kolom 'value' ada, hapus
        if (Schema::hasColumn('coupons', 'value')) {
            Schema::table('coupons', function (Blueprint $table) {
                $table->dropColumn('value');
            });
        }
    }
};
