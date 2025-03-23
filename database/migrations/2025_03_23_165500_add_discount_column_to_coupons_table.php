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
            // Cek apakah kolom value ada
            if (Schema::hasColumn('coupons', 'value')) {
                // Jika ada, rename value menjadi discount
                $table->renameColumn('value', 'discount');
            } else {
                // Jika tidak ada keduanya, tambahkan kolom discount
                $table->decimal('discount', 10, 2)->after('type');
            }
            
            // Cek apakah kolom usage_limit ada, jika ada rename menjadi max_uses
            if (Schema::hasColumn('coupons', 'usage_limit')) {
                $table->renameColumn('usage_limit', 'max_uses');
            }
            
            // Tambahkan kolom description jika belum ada
            if (!Schema::hasColumn('coupons', 'description')) {
                $table->text('description')->nullable()->after('is_active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            // Kembalikan nama kolom jika ada
            if (Schema::hasColumn('coupons', 'discount')) {
                $table->renameColumn('discount', 'value');
            }
            
            if (Schema::hasColumn('coupons', 'max_uses')) {
                $table->renameColumn('max_uses', 'usage_limit');
            }
            
            if (Schema::hasColumn('coupons', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};
