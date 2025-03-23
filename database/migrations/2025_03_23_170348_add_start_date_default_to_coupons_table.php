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
        Schema::table('coupons', function (Blueprint $table) {
            // Cek apakah kolom start_date ada
            if (Schema::hasColumn('coupons', 'start_date')) {
                // Ubah kolom start_date agar memiliki default value now()
                $table->timestamp('start_date')->default(now())->change();
            } else {
                // Jika tidak ada, tambahkan kolom start_date dengan default value now()
                $table->timestamp('start_date')->default(now())->after('is_active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            // Kembalikan start_date ke nullable jika diperlukan
            if (Schema::hasColumn('coupons', 'start_date')) {
                $table->timestamp('start_date')->nullable()->change();
            }
        });
    }
};
