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
            // Tambahkan kolom min_purchase jika belum ada
            if (!Schema::hasColumn('coupons', 'min_purchase')) {
                $table->decimal('min_purchase', 10, 2)->default(0)->after('discount');
            } else {
                // Jika sudah ada, ubah untuk menambahkan default value 0
                $table->decimal('min_purchase', 10, 2)->default(0)->change();
            }
            
            // Tambahkan kolom max_discount jika belum ada
            if (!Schema::hasColumn('coupons', 'max_discount')) {
                $table->decimal('max_discount', 10, 2)->default(0)->after('min_purchase');
            } else {
                // Jika sudah ada, ubah untuk menambahkan default value 0
                $table->decimal('max_discount', 10, 2)->default(0)->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            // Menghapus default value jika diperlukan, tetapi biasanya tidak perlu
            // karena kita hanya menambahkan default value
        });
    }
};
