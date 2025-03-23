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
            // Cek apakah kolom end_date ada
            if (Schema::hasColumn('coupons', 'end_date')) {
                // Jika ada, rename end_date menjadi expires_at
                $table->renameColumn('end_date', 'expires_at');
            } else if (!Schema::hasColumn('coupons', 'expires_at')) {
                // Jika tidak ada kolom expires_at, tambahkan kolom tersebut
                $table->timestamp('expires_at')->nullable()->after('used_count');
            }
            
            // Jika kolom start_date ada dan start_date tidak diperlukan lagi,
            // bisa dihapus atau direname sesuai kebutuhan
            // Dalam kasus ini kita biarkan untuk backward compatibility
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            // Kembalikan nama kolom jika ada
            if (Schema::hasColumn('coupons', 'expires_at')) {
                // Periksa apakah ini kolom yang direname atau yang baru ditambahkan
                if (Schema::hasColumn('coupons', 'end_date')) {
                    $table->dropColumn('expires_at');
                } else {
                    $table->renameColumn('expires_at', 'end_date');
                }
            }
        });
    }
};
